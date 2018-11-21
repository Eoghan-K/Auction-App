
var clientInfo;
var formData;
function initalizeRequest(fData){
    formData = fData;
    
}

function executeRequest(){
    $.ajax({
        type: "POST",
        url: 'scripts/SellItemDB.php',
        //dataType: 'json',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data){
           try {
                //parsing the data is not really important as the data as the encoded data is fine to use
                //parsing the data is just a a way to check it is a valid json before sending it to the changeLayout function
                var newdata = JSON.parse(data);
                
                if(newdata["message"] === 'success'){
                    alert('it worked ');
                }else{
                    alert('something went wrong ');
                }
            } catch (e) {
                alert(e);
            }
            
            
        },
        error:function(xhrm, statusText){
            alert("Error, could not get data from search: " + statusText);
        }
        
    });
}