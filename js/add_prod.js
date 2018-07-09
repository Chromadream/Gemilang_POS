function add_prod(id,tid,price)
{
    console.log("This function is called, right?");
    try
    {
        var xmlhttp = new XMLHttpRequest();
    }
    catch(e)
    {
        alert("AJAX not supported, please use newer browser");
        window.location.href = "https://google.com/chrome";
    }

    xmlhttp.open("GET","func/transact_wrapper.php?func=add_prod&id="+id+"&tid="+tid+"&price="+price);
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