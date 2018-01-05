function remove_prod(tid,id)
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
    xmlhttp.open("GET","transact_wrapper.php?func=remove_prod&id="+id+"&tid="+tid);
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
