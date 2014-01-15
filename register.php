<html>
    <head>
    <body >
        <font face="century gothic,verdana,arial">
        <p><a href="index.html" > Back to home </a></p>
        <br /><br />
        <div align="center">
            <h1> <font face="century gothic,verdana,arial">Create you own account</h1>
            <form method="post" id="form1" action="account/register.php"  onsubmit="return validateForm()">
                <p>User Name:<input type="text" name="username"></p>
                <p>Full Name:<input type="text" name="fullname"></p>
                <p>Email:<input  type="text" name="email"></p>
                <p>Password:<input id="pw1"type="password" name="password"></p>
                <p>Re-Type Password:<input  id="pw2" type="password" name="repassword"></p>
                <input type="hidden" value="broswer" name="function">
                <input type="submit" value="Submit">
            </form>
            <script>
                function validateForm()
                {
                    var fullname = document.forms["form1"]["fullname"].value;
                    var username = document.forms["form1"]["username"].value;
                    var email = document.forms["form1"]["email"].value;
                    var password = document.forms["form1"]["password"].value;
                    var repassword = document.forms["form1"]["repassword"].value;
                    if (fullname === '' || username === '' || email === '' || password === '' || repassword === '') {
                        alert("Not all fields has been filled!");
                        return false;
                    }
                    if (password != repassword) {
                        alert("The two passwords do not match, please enter again.");
                        return false;
                    }

                    var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!re.test(email)) {
                        alert("The email address you entered is not valid");
                        return false;
                    }
                    
                    if (password.length < 6){
                        alert("You need a stonger password");
                        return false;
                    }
                    
                    if(username.length < 3){
                        alert("Username need to be > 4 in length");
                        return false;
                    }
                }
            </script>
        </head>
    </div>
    </font>
</body>
</html>