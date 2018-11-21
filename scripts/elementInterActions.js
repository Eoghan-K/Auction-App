//these functions are ment to be used in multiple files to improve readability, only time will tell if I do make use of these functions
function DragDisablePageDefault(){
    //disable any default drag drop behaviour
    window.addEventListener("dragover",function(event){
        event.preventDefault();
    });
    window.addEventListener("drop",function(event){
        event.preventDefault();
    });
}

function fileUploadHiddenInput(divId, inputId, callback){
    var files;
    $(divId).on('click', function(){
        $(inputId).trigger('click');
    });

    $(inputId).on('click', function(event){
        event.stopPropagation();
    });

    $(inputId).on('change', function(event){
        callback($(inputId)[0].files);
    })
}

function dragSetup(element ,onEnterCB, onExitCB, onDropCB){
    $(element).on('dragbetterenter', function() {
        onEnterCB();
      })
      .on('dragbetterleave', function() {
        onExitCB();
      })

      dDArea.ondrop = function(event){
        onDropCB(event.dataTransfer.files);
    }
}