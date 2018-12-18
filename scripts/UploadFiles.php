<?php
include('DBConnection.php');

class uploadFiles extends DBConnection{
    private $file;
    private $userID, $imageID;
    private $SQLInsertDetails;
    private $PDOConnection, $query;
    private $rolledback;
    private $config;
    private $isSale, $isNewSale;
    //declare response messages
    private $respMsg, $respId, $respImgName;

    public function __construct(){
        //initalize response messages with default failure values;
        $this->respMsg = "something went wrong";
        $this->respId = '0';
        $this->respImgName = "not set";
        $this->rolledback = false;
        $this->isSale = $_POST['isSale'];
        if($this->isSale){
            $this->SQLInsertDetails = "INSERT INTO item_images(image_name, item_image_num) VALUES(:originalName, :imageNum)";
        }else{
            //add your query for user image upload here
            $this->SQLInsertDetails;

        }
        $this->config =parse_ini_file('../Config.ini');
    }

    public function processRequest(){
        if(!isset($_FILES['image'])){
            $this->respMsg = 'Error: Not a valid file';
        }else if(0 < $_FILES['image']['error']){
            $this->respMsg = 'Error: ' . $_FILES['image']['error'];
        }else{
            $this->file = $_FILES['image'];
            if(isset($this->file)){
                //validate the image 
                if($this->validateAndSanitize()){
                    $this->respId = $this->beginTransact();
                    $this->respMsg = "successful";
                }else{
                    $this->respMsg = "file dangerous";
                    
                }
            }else{
                $this->respMsg = "no file recieved";
            }
        }
        $this->encodeResults();
    }

    private function encodeResults(){
        //$responseArr = array();
        //$responseArr[0] = array();
        $responseArr['message'] = $this->respMsg; 
        $responseArr['id'] = $this->respId; 
        $responseArr['imageName'] = $this->respImgName;
        echo json_encode($responseArr);
    }

    protected function validateAndSanitize(){
        //this function should send the image off to be tested for malicious code
        //first check if file is correct file type if not exit script
        $fileType = $this->file['type'];
        if($fileType === "image/jpeg" || $fileType === "image/jpg" || $fileType === "image/png"){
            //now check if image contains any malicious code
            //for now we will skip virus checking as virustotal only allows 4 request and calmAV needs to be setup on its own server

            return true;
        }
        return false;
    }
    
    private function beginTransact(){
        try{
            //get user id from session (when setup for now we will just use id 2)
            $this->userID = 2;
            //if(isset($this->PDOConnection)){        
              //  $this->connectionSetup();
            //}
            //even though the connection maybe set we should still get a fresh version of the 
            //connection to ensure the variable has not been altered
            $this->PDOConnection = $this->getConnection();
            $this->PDOConnection->beginTransaction();

            $name = explode('.',$this->file['name']);
            $ext = end($name);
            $this->query = $this->PDOConnection->prepare($this->SQLInsertDetails);
            $this->query->execute(array('originalName'=>$name[0], 'imageNum'=>$_POST['id']));
            $imageID = $this->PDOConnection->lastInsertId();
            //upload image before commiting that way if the upload fails we dont have a stray row in the table
            //or need to find an delete that table
            $this->uploadImage($ext, $imageID);
            $this->PDOConnection->commit();
            return $imageID;
        }catch(Exception $e){
            $this->respMsg = "test Failed: " .  $e;
            $this->PDOConnection->rollBack();
            //implement function to delete images if rolled back
            $this->rolledback = true;
        }
    }

    private function uploadImage($fileExt, $imageID){
        //this function will upload the image(s) to the file server but only after image(s) have been validated
        $uploadSucess = false;

        $this->respImgName = "id" . $imageID . "inum" . $_POST['id'] . "." . $fileExt;
        if($this->isSale){
            $folder = ".." . $this->config["saleImages"];
        }else{
            $folder = ".." . $this->config["userImages"];
        }
        
        if(move_uploaded_file($this->file['tmp_name'], $folder . $this->respImgName)){
            $uploadSucess = true;
        }

        if(!$uploadSucess){
            throw new Exception('image could not be uploaded to file server');
        }
        
        return;
    }

}

$up = new uploadFiles();
$up->processRequest();
?>