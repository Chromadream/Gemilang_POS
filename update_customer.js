function update_customer(id) {
    try
    {
        var xmlhttp = new XMLHttpRequest();
    }
    catch(e)
    {
        alert("AJAX not supported, please use newer browser");
        window.location.href = "https://google.com/chrome";
    }


    let value = document.getElementById("customer").value;

    xmlhttp.open("GET","transact_wrapper.php?func=update_cust&id="+value+"&tid="+id);
    xmlhttp.onreadystatechange = triggered;
    xmlhttp.send(null);

    function triggered() {
        result = xmlhttp.responseText;
        console.log(xmlhttp.responseText);
        if ((xmlhttp.readyState == 4) && (xmlhttp.status==200))
        {
            alert("Customer telah didaftarkan dalam invoice.");
            window.location.href = "invoice.php?mode="+result;
        }
    }
}

