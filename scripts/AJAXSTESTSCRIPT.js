
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
           /*try {
                //var output = JSON.parse(data);
                //will remove as I do not need to parse the data but is good for testing
                alert("valid" + JSON.parse(data));
            } catch (e) {
                alert("Output is not valid JSON: " + data);
            }*/
            encodedData = data;
            changeLayout();
            
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
