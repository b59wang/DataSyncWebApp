<?php

session_start();
?>

<?php

if (isset($_SESSION['userid']))
    echo "<html><body><p>Welcome USER" . $_SESSION['userid'] . " </p></body></html>";
else {
    $_SESSION['views'] = 1;
    echo "<html><body><p>Please log in</p></body></html>";
    header("refresh:2;url=../index.html");
}
?>