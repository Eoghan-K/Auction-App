function purchaseItem(id){
    
    var fData = new FormData();
    fData.append("itemId",id);
    fData.append('type', 'purchase');
    if(initalizeRequest(fData)){
        executeRequest(fData);
    }else{
        alert('failed');
    }
}

function bidonItem(id){
    bidAmount = document.getElementById('bidAmount').value;
    bidGroup = document.getElementById('bidGroup').value;
    if(bidAmount === undefined || bidAmount === ""){
        alert('please enter bid amount');
    }else{
    var fData = new FormData();
    fData.append("itemId",id);
    fData.append('bidAmount', bidAmount);
    fData.append('bidGroup',bidGroup)
    fData.append('type', 'bid');
    if(initalizeRequest(fData)){
        executeRequest(fData);
    }else{
        alert('failed');
    }
    }
}