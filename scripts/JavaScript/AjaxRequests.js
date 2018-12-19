
var clientInfo;
var formData;
var urlRequest, requestType;


function initalizeRequest(fData){

    console.debug('fucking print');
    var result = false;
    switch(fData.get('type')){
        case 'saleSubmission':
            urlRequest = 'scripts/SaleController.php';
            requestType = 'POST';
            result = true;
            break;
        case 'userRegistration':
            console.debug('registration script selected');
            urlRequest = 'http://localhost/Auction-App/scripts/RegistrationDB.php';
            requestType = 'POST';
            result = true;
            break;
        default:
            console.log('request type not setup');
            result = false;
            break;
    }
    return result;
}

function executeRequest(fData){
    $.ajax({
        type: requestType,
        url: urlRequest,
        //dataType: 'json',
        data: fData,
        processData: false,
        contentType: false,
        success: function(data){
           try {
                var newdata;
                console.debug("data is =" + data);
                //parsing the data is not really important as the data as the encoded data is fine to use
                //parsing the data is just a a way to check it is a valid json before sending it to the changeLayout function
                newdata = JSON.parse(data);
                
                if(newdata["message"] === 'success'){
                    console.debug('it worked ');
                    return newdata;
                    
                }else if(newdata["message"] === "NotLoggedIn"){
                    //really things shouldn't get this far as PHP should deal with the redirection but redirections not implemented yet
                    console.log("you must be logged in to perform this action");
                    window.location.href = "/Auction-App/login.php";
                }else{
                    console.log(fData.get('type'));
                    console.log('something went wrong ');
                }
            } catch (e) {
                console.log("caught error " + e);
            }
            
            
        },
        error:function(xhrm, statusText){
            console.debug("Error: " + xhrm.status + " " + statusText);
        }
        
    });
}