
$(document).ready(function(){

    $('#submitBtn').on('click',function(){
        getAndPostData();
    }
    );
});

function getAndPostData(){
    var name, itemPrice, deliveryPrice, shortDesc, fullDesc, keywords, 
    condition, imageDetails;
    var fData = new FormData();
    //when controller is functional check all values are not null before posting
    name = document.getElementById('itemName').value;
    itemPrice = document.getElementById('itemPrice').value;
    deliveryPrice = document.getElementById('deliveryPrice').value;
    shortDesc = document.getElementById('shortDesc').value;
    fullDesc = document.getElementById('fullDesc').value;
    keywords = document.getElementById('keywords').value;
    condition = document.getElementById('condition').value;
    imageDetails = getImageDetails();
    if(imageDetails[0]['message'] !== undefined){
        
        fData.append('imageDetails', JSON.stringify(imageDetails));
    }
    fData.append('item_name', name);
    fData.append('item_price', itemPrice);
    fData.append('delivery_price',deliveryPrice);
    fData.append('short_description', shortDesc);
    fData.append('full_description',fullDesc);
    fData.append('keywords',keywords);
    fData.append('condition', condition);
    fData.append('type', 'saleSubmission');
    if(initalizeRequest(fData)){
        executeRequest(fData);
    }
}