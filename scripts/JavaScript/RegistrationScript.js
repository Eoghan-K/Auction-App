$(document).ready(function(){

    $('#submitBtn').on('click', function(){
        
        getValues();
    });
});

function getValues(){
    var firstName = document.getElementById('inputName1').value;
    var secondName = document.getElementById('inputName2').value;
    var email = document.getElementById('inputEmail').value;
    var username = document.getElementById('Username').value;
    var address = document.getElementById('homeAddress').value;
    var postCode = document.getElementById('postCode').value;
    var phoneNumber = document.getElementById('phoneNumber').value;
    var password = document.getElementById('inputPassword').value;
    var fData = new FormData();
    fData.append('type', "userRegistration");
    fData.append('firstname', firstName);
    fData.append('secondname', secondName);
    fData.append('username', username);
    fData.append('password', password);
    fData.append('email', email);
    fData.append('homeAddress', address);
    fData.append('postCode', postCode);
    fData.append('phoneNumber', phoneNumber);
    
    if(initalizeRequest(fData)){
        console.log('ready to make request');
        executeRequest(fData);
    }

}