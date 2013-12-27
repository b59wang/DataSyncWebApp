<?php

session_start();
?>

<?php

if (isset($_SESSION['userid'])){
    
} else {
    echo "<html><body><p>Please log in</p></body></html>";
    header("refresh:1;url=../index.html");
    die();
}
?>

<html>
    <head>
        
    </head>
    <body>
        <p> <a href="../account/logout.php"> Logout </a></p>
    <center>
        <h1>Welcome to DataSync</h1>
    </center>
    </body>
</html>