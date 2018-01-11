function search_by_phone(tid)
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
    let value = document.getElementById("phonenum").value;
    xmlhttp.open("GET","func/discount_wrapper.php?mode=phone&id="+value+"&tid="+tid);
    xmlhttp.onreadystatechange = triggered;
    xmlhttp.send(null);

    function triggered() {
        result = xmlhttp.responseText;
        if ((xmlhttp.readyState == 4) && (xmlhttp.status==200))
        {
            document.getElementById("phresult").innerHTML = result;
        }
    }
}

function search_by_id(tid)
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
    let value = document.getElementById("cardid").value;

    xmlhttp.open("GET","func/discount_wrapper.php?mode=id&id="+value+"&tid="+tid);
    xmlhttp.onreadystatechange = triggered;
    xmlhttp.send(null);

    function triggered() {
        result = xmlhttp.responseText;
        if ((xmlhttp.readyState == 4) && (xmlhttp.status==200))
        {
            document.getElementById("idresult").innerHTML = result;
        }
    }
}