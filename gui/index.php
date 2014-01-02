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

    </head>
    <body>
        <p> <a href="../account/logout.php"> Logout </a></p>
    <center>
        <h1>Welcome to DataSync</h1>
        <table border="1" align="center">
            <tr><th>type</th><th>value</th><th>date</th></tr>
            <?php
            include_once("../settings/connect.php");
            $query = "SELECT * FROM data WHERE userid = $userid";
            $result = mysqli_query($con, $query);
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><td align=\"center\">" . $row['type'] . "</td>";
                    if ($row['type'] == "text") {
                        echo "<td align=\"center\">" . $row['text'] . "</td>";
                    } else {
                        //TODO add other file type support
                    }
                    echo "<td align=\"center\">" . $row['date'] . "</td></tr>";
                }
            }
            ?>
        </table>
    </center>
</body>
</html>