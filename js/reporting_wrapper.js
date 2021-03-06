//please don't change anything here, it just works
function money_formatting(n){
    var c = 2, 
        t = ".", 
        d = ",", 
        s = n < 0 ? "-" : "", 
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
        j = (j = i.length) > 3 ? j % 3 : 0;
        return "Rp. " + s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

function daily_report(day,month,year,returnLocation,message)
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
    document.getElementById(returnLocation).innerHTML = '';
    xmlhttp.open("GET","func/reporting_wrapper.php?func=daily&d="+day+"&m="+month+"&y="+year);
    xmlhttp.onreadystatechange = triggered;
    xmlhttp.send(null);
    function triggered(){
        result = xmlhttp.responseText;
        if ((xmlhttp.readyState == 4) && (xmlhttp.status==200))
        {
            document.getElementById(returnLocation).innerHTML= money_formatting(result);
        }
    }
}

function batch_daily_report(month,year)
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
    var returnLocation = "monthlyspecs";
    document.getElementById(returnLocation).innerHTML = '';
    var parentElement = document.getElementById("monthlyspecs_wrapper");
    parentElement.style.visibility = "visible";
    var crDate = new Date(year,month,0);
    var endDate = crDate.getDate();
    var monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"];
    var MonthName = monthNames[crDate.getMonth()];
    xmlhttp.open("GET","func/reporting_wrapper.php?func=batch_daily&d="+endDate+"&m="+month+"&y="+year);
    xmlhttp.onreadystatechange = triggered;
    xmlhttp.send(null);
    function triggered(){
        result = JSON.parse(xmlhttp.responseText);
        if ((xmlhttp.readyState == 4) && (xmlhttp.status==200))
        {
            for (let index = 1; index <= endDate; index++) {
                document.getElementById(returnLocation).innerHTML += index + " " + MonthName + " " + year + ": ";
                document.getElementById(returnLocation).innerHTML += money_formatting(result[index-1]);
                document.getElementById(returnLocation).innerHTML += "<br/>";
            }
        }
    }
}

function monthly_report(month,year)
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

    xmlhttp.open("GET","func/reporting_wrapper.php?func=monthly&m="+month+"&y="+year);
    xmlhttp.onreadystatechange = triggered;
    xmlhttp.send(null);
    function triggered(){
        result = xmlhttp.responseText;
        if ((xmlhttp.readyState == 4) && (xmlhttp.status==200))
        {
            batch_daily_report(month,year);
            document.getElementById("monthly_sum").innerHTML = money_formatting(result);
        }
    } 
}

function yearly_report(year){
    try
    {
        var xmlhttp = new XMLHttpRequest();
    }
    catch(e)
    {
        alert("AJAX not supported, please use newer browser");
        window.location.href = "https://google.com/chrome";
    }
    xmlhttp.open("GET","func/reporting_wrapper.php?func=yearly&y="+year);
    xmlhttp.onreadystatechange = triggered;
    xmlhttp.send(null);
    function triggered(){
        result = xmlhttp.responseText;
        if ((xmlhttp.readyState == 4) && (xmlhttp.status==200))
        {
            document.getElementById("yearly_sum").innerHTML = money_formatting(result);
        }
    } 
}

function yearcalendar(endYear,onChangeFunction,currentYear){
    var start = "<select id='yearselector"+onChangeFunction+"'>"
    for (let index = 2018; index <= endYear; index++) {
        var selected = index ===currentYear ? "selected" : null;
        start += "<option value="+index+" "+selected+">"+index+"</option>"
    }
    return start;
}

function monthcalendar(onchangefunction,currentmonth)
{
    var start = "<select id='monthselector"+onchangefunction+"'>"
    for (let index = 1; index <= 12; index++) {
        var selected = index === currentmonth ? "selected" : null;
        start+="<option value="+index+" "+selected+">"+index+"</option>"
    }
    return start;
}

window.onload = function () {
    const todaydate = new Date();
    const year = todaydate.getFullYear();
    const month = todaydate.getMonth()+1;
    const day = todaydate.getDate();
    document.getElementById("yearreporting").innerHTML = yearcalendar(year,"yearreport",year);
    document.getElementById("monthreporting").innerHTML = yearcalendar(year,"monthreport",year);
    document.getElementById("monthreporting").innerHTML+=monthcalendar("monthreport",month);
    document.getElementById("dailypicker").value = todaydate.toISOString().substring(0,10);
    daily_report(day,month,year,"daily_sum","");
    monthly_report(month,year);
    yearly_report(year);
    document.getElementById("monthselectormonthreport").addEventListener("change",monthlyreportwrapper);
    document.getElementById("yearselectormonthreport").addEventListener("change",monthlyreportwrapper);
    document.getElementById("yearselectoryearreport").addEventListener("change",yearlyreportwrapper);
    document.getElementById('dailypicker').addEventListener("change",dailyreportwrapper);
}

function dailyreportwrapper() {
    const date = new Date(document.getElementById('dailypicker').value);
    const year = date.getFullYear();
    const month = date.getMonth()+1;
    const day = date.getDate();
    daily_report(day,month,year,"daily_sum","");
}

function monthlyreportwrapper(){
    const month = document.getElementById("monthselectormonthreport").value
    const year = document.getElementById("yearselectormonthreport").value
    monthly_report(month,year);
}

function yearlyreportwrapper(){
    const year = document.getElementById("yearselectoryearreport").value
    yearly_report(year)
}

