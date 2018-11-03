<?php
class uploadFiles{
    private $isNewSale;
    private $files;
    public function __construct($isNewSale = true){
        $this->isNewSale = $isNewSale;
        $files = array();
    }
    
    private function validateImage(){
        //this function should send the image off to be tested for malicious code
        
        
    }
    
    private function submitImage($image){
        //this function will send the script to the validate function and store the image in an array if valid
        if(isset($_FILES['image'])){
            $fileName = $_FILES['image']['name'];
            $extentions = explode('.', $fileName);
            //if there is more than 1 extention then dont bother uploading as it could be dangerous 
            if(!(count($extentions) > 1) && ($extentions === "png" || $extentions === "jpg" || $extentions === "jpeg")){
                
            }
            
        }
    }
    
    public function uploadImage(){
        //this function will upload the image(s) to the file server but only after image(s) have been validated
        
    }
}
?>