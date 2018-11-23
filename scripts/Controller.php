<?php
//include('UploadFiles.php');
include('SellItemDB.php');
//this is just a temporary file until I have time to implement a Front Controller pattern
//or someother controller pattern that matches our project (should have done this at the start of the project)
//for the most part this is just gonna be hardcoded since it is a very small site anyway the code should not be that long
class controller{
    private $targetScript;
    private $page, $type, $data;

    public function __construct(){
        $this->page = $_POST['page'];
        $this->type = $_POST['type'];
        $this->data = $_POST['data'];
        
    }

    public function makeRequest(){
        switch($this->page){
            case "sellItem";
                //if($this->type === "image"){
                    //$this->targetScript = new uploadFiles($_FILES['image'], $_POST['id']);
                    //$this->targetScript->processRequest();
                //}else{
                    $this->targetScript = new sellItemDB();
                //}
            break;
        }
    }

}

$controller = new controller();
$controller->makeRequest();


?>