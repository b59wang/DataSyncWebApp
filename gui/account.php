<?php
session_start();
?>
<?php
if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
} else {
    echo "<html><body><p>Please log in</p></body></html>";
    header("refresh:1;url=../index.html");
    die();
}
?>

<html>
    <head>
        <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.10.2.min.js"></script>
    </head>
    <body>
        <font face="century gothic,verdana,arial">
        <a href="index.php">Main</a> <br />
        <a href="../account/logout.php"> Logout </a>
    <center>
        <h2>Welcome to DataSync</h2>
        <h3>---current user info---</h3>
        <table border="1" align="center">
            <tr><th>Username</th><th>Name</th><th>Email</th></tr>
            <?php
            include_once("../settings/connect.php");
            $query = "SELECT * FROM users WHERE userid = $userid";
            $result = mysqli_query($con, $query);
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><td align=\"center\">" . $row['username'] . "</td>";
                    echo "<td align=\"center\">" . $row['fullname'] . "</td>";
                    echo "<td align=\"center\">" . $row['email'];
                    echo "</td></tr>";
                }
            }
            ?>
        </table>
    </center>
    </font>
</body>
</html>