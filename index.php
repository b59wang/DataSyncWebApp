<?php   
session_start();
if (isset($_SESSION['userid'])) {
    header("location:http://localhost/DataSyncWebApp/gui/index.php");
}
?>
<html>
    <head>
    </head>
    <body >
        <br /><br /><br />
        <font face="century gothic,verdana,arial">
        <div align="center">
            <h1> <font face="century gothic,verdana,arial">DataSync Web Portal</h1>
            <form method="post" action="gui/index.php" name="aform" target="_top">
                <p>
                    Login:</font></td><td><input type="text" name="username">
                    </p>
                    <p>
                    <font face="century gothic,verdana,arial" size=-1>Password:</font></td><td><input type="password" name="password">
                    </p>
                    <input type="submit" value="Submit">
                    <input type="hidden" name="function" value="broswer">
            </form>
            <p><a href="register.php" >Create an Account </a></p>
        </div>
        </font>
    </body>
</html>