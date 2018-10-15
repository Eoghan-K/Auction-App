function testAjax(data){
    alert("called");
    var ajax = new XMLHttpRequest();
    var reference = document.getElementById('search_wrapper');
    
    ajax.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            //child node 20 will be null so element will be placed last in the div
            //reference.insertBefore(this.response, reference.childNodes[20]);
            
            reference.innerHTML = this.response;
        }
    }
    
    ajax.open('GET','searchDB.php?data=' + data);
    ajax.send();
}