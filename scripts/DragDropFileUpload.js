var dDArea = document.getElementById('DDrow');
var uploadBtn = document.getElementById('legacyUploadBtn');
var userPrompt = document.getElementById('userPrompt');
var iconRow = dDArea.getElementsByClassName('icon-Row');
var originalClassName;
var data = new Array();
var index = 0;
var allRetValues = new Array();

window.addEventListener("beforeunload", function (event) {
    //must create a php script designed to clean-up any scripts that have been abruptly
    //in this case if the user has uploaded images but not submitted the item for sale 
    //then this should send clean up type and image ids, after which the php script
    //should then drop the db record and delete the image of each submitted image.
    //set var to be sent to script
    var cleanupType = "saleImageUpload";

    event.preventDefault();
    // Chrome requires returnValue to be set.
    event.returnValue = '';
});

$(document).ready(function(){
    dragStatus = 0;
    index = 0;
    
    //disable any default drag drop behaviour
    window.addEventListener("dragover",function(event){
        event.preventDefault();
    });
    window.addEventListener("drop",function(event){
        event.preventDefault();
    });
    
    //first load the original class name of the element
    originalClassName = dDArea.className;

    $('#legacyUploadBtn').on('click', function(){
        $('#hiddenBtn').trigger('click');
        
    });

    $('#hiddenBtn').on('click', function(event){
        event.stopPropagation();
    });

    $('#hiddenBtn').on('change', function(event){
        beginProcessing($('#hiddenBtn')[0].files);
    })

    $(dDArea).on('dragbetterenter', function() {
        alterDDAreaDesign();
      })
      .on('dragbetterleave', function() {
        resetDDAreaDesign();
      })

    dDArea.ondrop = function(event){
        beginProcessing(event.dataTransfer.files);
    }

});

function alterDDAreaDesign(){
    
    dDArea.className += " " + "activeDrag";
    userPrompt.getElementsByTagName('h1')[0].innerHTML = "Drop to upload";
}

function resetDDAreaDesign(){
    dDArea.className = originalClassName;
    userPrompt.getElementsByTagName('h1')[0].innerHTML = "Drag your images here";
}

function beginProcessing(files){
    //reset design
    dDArea.className = originalClassName;
    userPrompt.getElementsByTagName('h1')[0].innerHTML = "Drag your images here";
    //get data
    for(var i = 0; i < files.length; i++){
        data.push(files[i]);
    }
    
    var elemCount = data.length;
    //the max amount of images for each sale is 10 so ensure if the user trys to upload more than 10 
    //ignore anything past 10
    var tempValue = (elemCount > 10 ? 10 : elemCount);
    
    for(index; index < tempValue; index++ ){
        //alert("called")
        $(iconRow).append('<div class="col-1 imageIcon">'+
        '<div class="progress">'+
        '<div id="progressB-'+ index +'" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>'+
        '</div></div>');
        uploadImage(data[index], index);
    }
    //begin process will upload the image to php while reporting the upload progress
    //then report if the image is allowed on the server
}

function uploadImage(image, progressID){

    $('#progressB-'+progressID).css('width', '10%');
    //checking if folder if it has no file type and is in multiples of 4096 then it could be a folder
    if(!image.type && image.size % 4096 == 0){//!checkFile(image) ){
        
        //this is not a fool proof setup but it should hopefully minimize
        //the amount of requests made with folders
        uploadFailed(progressID);
        return;
    }
    var page = $('#DragD').attr('title');
    var fData = new FormData();
    fData.append('image',image);
    //tells the server if the image is for a user profile pic or sale pic if sale pic is it for a new sale
    //other features not yet implemented so default both to true
    if(page === "saleItem"){
        fData.append('isSale',"true");
        fData.append("isNewSale", "true");
    }else{
        fData.append('isSale',"false");
        fData.append("isNewSale", "false");
    }
    fData.append('id', progressID);
    var interval;
    $.ajax({
        type: "POST",
        url: 'scripts/UploadFiles.php',
        enctype: 'multipart/form-data',
        data: fData,
        processData: false, 
        contentType: false,
        beforeSend:function(){
            $('#progressB-'+progressID).css('width', '20%');
        },
        xhr: function(){
            var XhtmlReq = new window.XMLHttpRequest();
            XhtmlReq.upload.addEventListener("progress", function(event){
                if(event.lengthComputable){
                    var percentage = event.loaded / event.total;
                    $('#progressB-'+progressID).css('width', percentage + '%');
                }
            },false);

            XhtmlReq.addEventListener("progress", function(event){
                if(event.lengthComputable){
                    var percentage = event.loaded / event.total;
                    $('#progressB-'+progressID).css('width', percentage + '%');
                }
            },false);
            return XhtmlReq;
        },
        /* must test both versions of xhr when on server
        xhr: function(_this){
            var xhr;
            xhr = jQuery.ajaxSettings.xhr();
            interval = setInterval(function(){
                var completed, percentage, total;
                if(xhr.readyState > 2){
                    total = parseInt(xhr.getResponseHeader('Content-length'));
                    completed = parseInt(xhr.responseText.length);
                    percentage = (100/total*completed).toFixed(2);
                    //alert(percentage + '%');
                    $('#progressB-'+progressID).css('width', percentage + '%');
                }
            }, 50);
            return xhr;
        },*/
        complete: function(data){
            //re-enable on server things happen to fast locally to see progress bar
            //$('#progressB-' + progressID).closest('.progress').hide();
            $('#progressB-'+progressID).css('width', '100%');
            //return clearInterval(interval);
        },
        success: function(data){
            try{
                //alert(data);
                var recievedJson = JSON.parse(data);
                var message = recievedJson['message'];
                
                if(data && message !== "successful"){
                    //alert('upload failed');
                    uploadFailed(progressID);

                }else{
                    processDetails(recievedJson)
                }
            }catch(e){
                alert("error caught " + e);
                uploadFailed(progressID);
            }
            
        },
        error:function(xhrm, statusText){
            alert("status error: " + statusText);
            uploadFailed(progressID);
        }
    });
}

function processDetails(recievedJson){
    allRetValues.push(recievedJson);
}

function getImageDetails(){
        return allRetValues;
}

function checkFile(tempFile){
     //checking if folder if it has no file type and is in multiples of 4096 then it could be a folder
    if(!tempFile.type && tempFile.size % 4096 == 0){
        //TODO give reason why failed
        return false;
    }else if(tempFile.type.includes("application/x-")){
        //tell the user fuck all cheeky lil b*******
        return false;
    }else if(tempFile.type !== "image/jpeg" || tempFile.type !== "image/png" || tempFile.type !== "image/jpg" ){
        //TODO give user reasons why it failed
        return false;
    }else{
        return true;
    }
}

function uploadFailed(progressID){
    $('#progressB-' + progressID).closest('.imageIcon').css('background',"url('images/icons/svg/brokenPhoto.svg')");
    $('#progressB-'+progressID).css('background-color', 'red');
    $('#progressB-'+progressID).css('width', '100%');
}

