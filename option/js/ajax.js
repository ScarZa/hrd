//<!-------code ajax load page ตอน link page------->
var HttPRequest = false;

function doMethod(url) {
    HttPRequest = false;
    if (window.XMLHttpRequest) { // Mozilla, Safari,...
        HttPRequest = new XMLHttpRequest();
        if (HttPRequest.overrideMimeType) {
            HttPRequest.overrideMimeType('text/html');
        }
    } else if (window.ActiveXObject) { // IE
        try {
            HttPRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                HttPRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
            }
        }
    }

    if (!HttPRequest) {
        alert('Cannot create XMLHTTP instance');
        return false;
    }

    var pmeters = "";

    HttPRequest.open('POST', url, true);

    HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    HttPRequest.setRequestHeader("Content-length", pmeters.length);
    HttPRequest.setRequestHeader("Connection", "close");
    HttPRequest.send(pmeters);


    HttPRequest.onreadystatechange = function ()
    {

        if (HttPRequest.readyState == 3)  // Loading Request
        {
            document.getElementById("mySpan").innerHTML = "Now is Loading...";
        }

        if (HttPRequest.readyState == 4) // Return Request
        {
            document.getElementById('mySpan').innerHTML = HttPRequest.responseText;
        }
    }

}

function User_add()//ใช้ส่งค่าไปหน้าอื่น
{
    var user = document.getElementById('frm1').username.value;
    var pass = document.getElementById('frm1').password.value;
    var fname= document.getElementById('frm1').fname.value;
    var lname= document.getElementById('frm1').lname.value;
     //alert(user);
    var req;
    if (window.XMLHttpRequest)
        req = new XMLHttpRequest();
    else if (window.ActiveXObject)
        req = new ActiveXObject("Microsoft.XMLHTTP");
    else
    {
        alert("Browser not support");
        return false;
    }
    req.onreadystatechange = function ()
    {
        if (req.readyState == 4)
        {
            document.getElementById("myShow").innerHTML = req.responseText;
        }
    }
    var querystr = "";
    querystr += "add_user_query.php";
    //alert(querystr);
    req.open("POST", querystr, true);
    req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    req.send("user=" + user +"&pass="+pass+"&fname="+fname+"&lname="+lname);
    frm1.reset();//reset form

} 
function alter_me(){
    alert('THIS PROGRAM');
    
}