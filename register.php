<html>
<head>
<script>
function validateForm()
{
	alert("asdf");
	var fullname = document.forms["form1"]["fullname"].value;
	var username = document.forms["form1"]["username"].value;
	var email = document.forms["form1"]["email"].value;
	
	if (fullname==null || fullname=="" || username==null || username=="" || email==null || email=="" ) {
		alert("Fields must be filled out");
		return false;
	}
	x=document.forms["form1"]["email"].value;
	var atpos=x.indexOf("@");
	var dotpos=x.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length){
		alert("Not a valid e-mail address");
		return false;
	}
	
	var pw1 = document.getElementById('pw1').value;
	var pw2 = document.getElementById('pw2').value;
	if (pw1 != pw2 || pw1.length < 4){
		alert("Password are not the same, please try again.");
		return false;
	} else if (){
		alert("Invalid email address");
		return false;
	}
	
	document.getElementById("form1").submit();
	return true;
}
</script>
</head>
<body >
<font face="century gothic,verdana,arial">
<p><a href="index.php" > Back to home </a></p>
<br /><br />
<div align="center">
<h1> <font face="century gothic,verdana,arial">Create you own account</h1>
<form method="post" id="form1" action="account/register.php"  onsubmit="return validateForm()">
<p>User Name:<input type="text" name="username"></p>
<p>Full Name:<input type="text" name="fullname"></p>
<p>Email:<input  type="text" name="email"></p>
<p>Password:<input id="pw1"type="password" name="password"></p>
<p>Re-Type Password:<input  id="pw2" type="password" name="repassword"></p>
<input type="submit" value="Submit" onclick="validateForm();">
</form>
</div>
</font>
</body>
</html>