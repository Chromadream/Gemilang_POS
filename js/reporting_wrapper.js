
//please don't change anything here, it just works
function money_formatting(n){
    var c = 2, 
        t = ".", 
        d = ",", 
        s = n < 0 ? "-" : "", 
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
        j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};
function daily_AJAX(day,month,year)
{
    try
    {
        var xmlhttp = new XMLHttpRequest();
        var returned;
    }
    catch(e)
    {
        alert("AJAX not supported, please use newer browser");
        window.location.href = "https://google.com/chrome";
    }

    xmlhttp.open("GET","func/reporting_wrapper.php?func=daily&d="+day+"&m="+month+"&y="+year);
    xmlhttp.onreadystatechange = triggered;
    xmlhttp.send(null);
    function triggered(){
        result = xmlhttp.responseText;
        console.log(result);
        if ((xmlhttp.readyState == 4) && (xmlhttp.status==200))
        {
            returned = "Rp."+money_formatting(result.substring(1));
        }
    }
    console.log(returned);
    return returned;
}
function daily_report(day,month,year)
{
    let x = daily_AJAX(day,month,year);
    console.log(x);
    document.getElementById("daily_sum").innerHTML = x;
}

function batch_daily_report(endDate,month,year)
{
    var outputHTML="";
    var location = document.getElementById("monthlyspecs");
    var wrapper = document.getElementById("monthlyspecs_wrapper");
    for (let index = 1; index <= endDate; index++) {
        outputHTML+=daily_AJAX(index,month,year);
        outputHTML+="<br/>";
    }
    wrapper.style.visibility = 'visible';
    location.innerHTML = outputHTML;
}

function monthly_report(day,month,year)
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
            batch_daily_report(day,month,year);
            document.getElementById("monthly_sum").innerHTML = "Rp."+money_formatting(result.substring(1));
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
    console.log(year);
    xmlhttp.open("GET","func/reporting_wrapper.php?func=yearly&y="+year);
    xmlhttp.onreadystatechange = triggered;
    xmlhttp.send(null);
    function triggered(){
        result = xmlhttp.responseText;
        console.log(result)
        if ((xmlhttp.readyState == 4) && (xmlhttp.status==200))
        {
            document.getElementById("yearly_sum").innerHTML = "Rp."+money_formatting(result.substring(1));
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
    daily_report(day,month,year);
    monthly_report(day,month,year);
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
    daily_report(day,month,year);
}

function monthlyreportwrapper(){
    const day = new Date().getDate();
    const month = document.getElementById("monthselectormonthreport").value
    const year = document.getElementById("yearselectormonthreport").value
    monthly_report(day,month,year);
}

function yearlyreportwrapper(){
    const year = document.getElementById("yearselectoryearreport").value
    yearly_report(year)
}

