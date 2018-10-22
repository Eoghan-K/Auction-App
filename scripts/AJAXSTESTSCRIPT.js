
var $reference = $('#test');
//defaults to true
var isGrid = true;
var encodedData;

window.loadInformation = function(data, grid, newInformation){
    if(grid === isGrid && newInformation === false){
        //there is nothing left to do so exit script
        return;
    }
    
    isGrid = grid;
    if(newInformation){
        loadNewInfo(data);
    }else{
        changeLayout();
    }
    
    
}

function loadNewInfo(query){
   
    
    $.ajax({
        async: false,
        type: "POST",
        url: 'scripts/SearchDB.php',
        data: {
                'query': query,
                'grid' : isGrid
            },
        success: function(data){
           try {
                //parsing the data is not really important as the data as the encoded data is fine to use
                //parsing the data is just a a way to check it is a valid json
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
        async: false,
        type: "POST",
        url: 'scripts/ConstructPage.php',
        dataType: 'html',
        data: {'data':encodedData, 'layout':isGrid},
        success: function(data){
            //$reference.append(data);
            //alert(data);
            //$reference.append(data);
            $reference.html(data);
        },
        error:function(xhrm, statusText){
            alert("Error, could not construct page from data: " + statusText);
        }
        
    });
    
}
