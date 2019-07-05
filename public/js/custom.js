/********************************************************************************************************* */
/*Funkcija pakeisti orderio busena*/ 
/********************************************************************************************************* */
function myFunction(s) {
/*************Apsirasau kintamuosius*****************/
    var value =s[s.selectedIndex].value;
    var id =s.id;
    var line=document.getElementById("line"+id);
  
 
/*********Siuncia i db****************************** */ 
    const Http = new XMLHttpRequest();
    var fullurl=document.location.origin;
    fullurl=fullurl.concat('/api/order/status/');
    fullurl=fullurl.concat(id);
    fullurl=fullurl.concat('/');
    fullurl=fullurl.concat(value);
   
    Http.open("PUT", fullurl,true);
 /* 
                Http.onreadystatechange = function()
{
    if(Http.readyState == 4 && Http.status == 200)
    {
        alert(Http.responseText);
    }
}*/          
      
        Http.send(); 

/******************Pakeiciu spalvas******************** */
if(value==2){
    if ( line.classList.contains('redLine')){
        line.classList.remove('redLine');
        line.classList.add('greenLine');
      
    }
    else if(line.classList.contains('orangeLine')){
        line.classList.remove('orangeLine');
        line.classList.add('greenLine');
    }
}
else if(value==1){
    if ( line.classList.contains('greenLine')){
        line.classList.remove('greenLine');
        line.classList.add('orangeLine');

    }
    else if(line.classList.contains('redLine')){
            line.classList.remove('redLine');
            line.classList.add('orangeLine');
    
    }
}
else if(value==0) {
    if (line.classList.contains('greenLine')) {
        line.classList.remove('greenLine');
        line.classList.add('redLine');
    }
    else if(line.classList.contains('orangeLine')){
            line.classList.remove('orangeLine');
            line.classList.add('redLine');

    } else if (line.classList.contains('orangeLine')) {
        line.classList.remove('orangeLine');
        line.classList.add('redLine');


        /************************************************** */
    }
    /*********************************************************************************************************************************/
    /*Funkcija pakeicia produkto aktyvuma*/

    /*********************************************************************************************************************************/
    function isActive(s) {
        /************Apsirasau kintamuosius*************/
        var value = s[s.selectedIndex].value;
        var id = s.id;
        var is_active = document.getElementById("active" + id);
        var domain = document.location.origin;
        /*****************Siuncia i db********************** */
        const Http = new XMLHttpRequest();
        var fullurl = document.location.origin;
        fullurl = fullurl.concat('/api/product/isactive/');
        fullurl = fullurl.concat(id);
        Http.open("PUT", fullurl, true);
        /*      Jei reikia eroro is db
                Http.onreadystatechange = function()
        {
            if(Http.readyState == 4 && Http.status == 200)
            {
                alert(Http.responseText);
            }
        }    */
        Http.send();

        /************Pakeiciu spalvas******************* */
        if (is_active.classList.contains('not-active')) {
            is_active.classList.remove('not-active');

        } else {
            is_active.classList.add('not-active');
        }
    }
}
}
