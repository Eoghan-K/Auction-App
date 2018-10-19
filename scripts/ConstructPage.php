<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ConstructPage{
    private $isGrid;
    private $itemArray;
    private $config;
    private $htmlString;
    
    public function __construct($encodedValues, $isGrid){
        $this->config =parse_ini_file('../Config.ini');
        //if the grid value passed in is set then set isGrid to specified else just set it to the default which is true
        if(isset($isGrid)){
            $this->isGrid = $isGrid;
        }else{
            //default to true
            $this->isGrid = true;
        }
        
        //initialize array
        $this->itemArray = array();
        //decode the array passed in and store it in itemArray
        $this->itemArray = json_decode($encodedValues,true);
        //construct the page
        $this->constructLayout();
    }
    
    public  function updateData($encodedValues){
        //decode array
        $this->itemArray = json_decode($encodedValues, true);
        //update page with new values
        $this->constructLayout();
    }
    
    public function updateLayout($isGrid){
        //if the grid value passed in is set and the new value is not equal to the old value then update the page
        //else do nothing
        if(isset($isGrid) && $isGrid !== $this->isGrid){
            $this->isGrid = $isGrid;
            $this->constructLayout();
        }
       
    }
    
    public function constructLayout(){
        //for some reason php seems to get confused about what datatype my bool is so leaving both bool and string comparisons 
        if($this->isGrid === true || $this->isGrid === "true"){
            
            $this->createGridview();
        }else{
            $this->createListview();
        }
    }
    
    private function createGridview(){
        
        //get the number of items in an array
        $numItems = count($this->itemArray);
        //calculate the max number of rows needed to display those items
        $numOfRows = ceil($numItems / 4);
        
        //echo "number of items: ".$numItems . "number of rows " . $numOfRows;
        //index is used to keep track of the currently selected item in the array, might make this global and also use it to change pages.
        $indexCols = 0;
        $currentRowItem = 0;
        $indexRows = 0;
        
        //loop for rows
        while($indexRows < $numOfRows && $numOfRows > 0){
            ?><div class='row card_row'><?php
           //get the remainder which is number of items minus the index columns
            $remainder = ($numItems-$indexCols);
             //if remainder is greater than 4 return 4 else return remainder
            $currentRowItem = $remainder > 4 ? 4 : $remainder;
           
            //loop for individual items
            while($currentRowItem > 0){
                //TODO add image name and short description to db
                $imageName = $this->itemArray[$indexCols]['image_name'];
                $shortDescription = $this->itemArray[$indexCols]['short_description'];
                //NOTE the server should hold the path and the database should hold the name on server
                //this is so if file structer is ever changed the database will not have to be updated
                $imgUrl = $this->itemArray[$indexCols]['image_url'];
                $itemName = $this->itemArray[$indexCols]['item_name'];
                
                //now that all nessicary data is gathered its time to print to screen
                
                ?><a href="<?=$itemUrl ?>" class="col-12 col-sm-6 col-md-3">
                        <div class="card">
                          <img class="card-img-top" src="<?php echo $this->config["saleImages"] . $imgUrl;?>" alt="<?=$imageName ?>">
                          <div class="card-body">
                            <h5 class="card-title"><?=$itemName ?></h5>
                            <p class="card-text"><?=$shortDescription ?></p>
                          </div>
                        </div>
                    </a><?php
                
                //take away the number of rows needed and increase the current column number
                $currentRowItem--;
                $indexCols++;
                
            }
            $indexRows++;
            ?></div><?php 
        
        }
       
    }
    
    private function createListview(){
       
        //get the number of items in an array
        $numItems = count($this->itemArray);
        //calculate the max number of rows needed to display those items
        $numOfRows = ceil($numItems / 4);
        
        //store current item row to keep track of how many items are needed for the next page(next page not yet implemented)
        $currentItem = 0;
        
        
        //loop for rows
        for($i = 0; $i < $numItems; $i++){
            ?><div class='row card_row'><?php
                //TODO add image name and short description to db
                $imageName = $this->itemArray[$i]['image_name'];
                $shortDescription = $this->itemArray[$i]['short_description'];
                //NOTE the server should hold the path and the database should hold the name on server
                //this is so if file structer is ever changed the database will not have to be updated
                $imgUrl = $this->itemArray[$i]['image_url'];
                $itemName = $this->itemArray[$i]['item_name'];
                
                //now that all nessicary data is gathered its time to print to screen
                
                ?><a href="<?=$itemUrl ?>" class="col-12 col-sm-6 col-md-3">
                        <div class="card">
                          <img class="card-img-top" src="<?php echo $this->config["saleImages"] . $imgUrl;?>" alt="<?=$imageName ?>">
                          <div class="card-body">
                            <h5 class="card-title"><?=$itemName ?></h5>
                            <p class="card-text"><!--<?=$shortDescription ?>--> This has now changed to list view in my mind some day in reality</p>
                          </div>
                        </div>
                    </a><?php
                ?></div><?php 
            }
    }
}

$data = $_POST['data'];
$layoutT = $_POST['layout'];
new ConstructPage($data, $layoutT);

?>