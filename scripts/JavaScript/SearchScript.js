
var $reference = $('#test');
//defaults to true
var isGrid = true;
var encodedData;


window.loadInformation = function(data, grid, newInformation, isCurrentListings){
    if(grid === isGrid && newInformation === false){
        //there is nothing left to do so exit script
        return;
    }
    
    isGrid = grid;
    if(isCurrentListings){
       
        query = {'query': data,
                'grid' : isGrid,
                'type':'currentListings'}
        loadNewInfo(query);
    }else if(newInformation){
        
        query = {'query': data,
                'grid' : isGrid,
                'type':'search'}
        
        loadNewInfo(query);
        
    }else{
        changeLayout();

    }
    
    
}

function loadNewInfo(query){
   
    
    $.ajax({
        type: "GET",
        url: 'scripts/SearchDB.php',
        data: query,
        success: function(data){
           try {
                //parsing the data is not really important as the data as the encoded data is fine to use
                //parsing the data is just a a way to check it is a valid json before sending it to the changeLayout function
                JSON.parse(data);
                encodedData = data;
                changeLayout();
            } catch (e) {
                $reference.html("<h2>" + data + "</h2>");
            }
            
            
        },
        error:function(xhrm, statusText){
            alert("Error, could not get data from search: " + statusText);
        }
        
    });
    
}

function changeLayout(){
    
    $.ajax({
        type: "GET",
        url: 'scripts/ConstructPage.php',
        //dataType: 'html',
        data: {'data':encodedData, 'layout':isGrid},
        success: function(data){
            //get the html back from the page constructer and place it in the page
            $reference.html(data);
        },
        error:function(xhrm, statusText){
            alert("Error, could not construct page from data: " + statusText);
        }
        
    });
    
}
