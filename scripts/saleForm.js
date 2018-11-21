
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
    name = document.getElementById('itemName');
    itemPrice = document.getElementById('itemPrice');
    deliveryPrice = document.getElementById('deliveryPrice');
    shortDesc = document.getElementById('shortDesc');
    fullDesc = document.getElementById('fullDesc');
    keywords = document.getElementById('keywords');
    condition = document.getElementById('condition');
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
    initalizeRequest(fData);
    executeRequest();
}