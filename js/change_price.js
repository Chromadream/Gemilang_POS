function change_price(id,tid)
{
    try
    {
        var xmlhttp = new XMLHttpRequest();
    }
    catch(e)
    {
        alert("AJAX not supported, please use newer browser");
        window.location.href = "https://google.com/chrome";
    }
    let value = document.getElementById(tid).value;

    xmlhttp.open("GET","func/transact_wrapper.php?func=change_price&id="+id+"&tid="+tid+"&price="+value);
    xmlhttp.onreadystatechange = triggered;
    xmlhttp.send(null);
    
    function triggered(){
        result = xmlhttp.responseText;
        if ((xmlhttp.readyState == 4) && (xmlhttp.status==200))
        {
            window.location.href = "invoice.php?mode="+result;
        }
    }
}
