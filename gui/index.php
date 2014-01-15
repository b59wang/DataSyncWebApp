
<?php
// includes
include_once("../includes/functions.php");
include_once("../settings/connect.php");
include_once("../settings/debug.php");

session_start();
if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
} else if (checkPostExists("username") && checkPostExists("password")) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $checkQuery = "SELECT userid,salt,password FROM users WHERE username = '$username';";
    $result = mysqli_query($con, $checkQuery);
    if ($result) {
        if (mysqli_num_rows($result) == 0) {
            echo "<html><body><center><p>Wrong username or password</p>"
            . "<p>Back to <a href='../index.html'>Home</a></p></center></body></html>";
            die();
        }
        $row = mysqli_fetch_array($result);
        $hash_pass = hash("sha256", $password . $row['salt']);
        if ($hash_pass == $row['password']) {
            session_destroy();
            session_start();
            $_SESSION['userid'] = $row['userid'];
            $userid = $_SESSION['userid'];
        } else {
            echo "<html><body><center><p>Wrong username or password</p>"
            . "<p>Back to <a href='../index.html'>Home</a></p></center></body></html>";
            die();
        }
    } else {
        echo "<html><body><center><p>Problem accessing account, please try again.</p>"
        . "<p>Back to <a href='../index.php'>Home</a></p></center></body></html>";
        die();
    }
} else {
    session_start();
    session_destroy();
    echo "<html><body><center><p>Please login</p>"
    . "<p>Back to <a href='../index.php'>Home</a></p></center></body></html>";
    die();
}
?>

<html>
    <head>
        <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.10.2.min.js"></script>
    </head>
    <body>
        <font face="century gothic,verdana,arial">
        <a href="account.php">My account</a> <br />
        <a href="../account/logout.php"> Logout </a>
    <center>
        <h2>Welcome to DataSync</h2>

        <h3>---upload---</h3>
        <form method="post" id="form1">
            Text:<input type="text" id="inputField" name="text"> <br /> File:<input type="file" name="file" id="file"> <br />
            <input type="hidden" id="ajaxtype" value="text" name="type">
            <input type="hidden" value="<?php echo $userid; ?>" name="userid">
            <input type="submit" id="submit1" value="Submit" >
        </form>
        <script>
            $("#form1").submit(function(e)
            {

                var file = $('#file').val();
                if (file == '') {
                    $('#ajaxtype').val("text");
                } else {
                    $('#ajaxtype').val("file");
                }

                $.ajax({
                    url: "http://localhost/DataSyncWebApp/json/upload.php",
                    type: "POST",
                    data: $('#form1').serialize(),
                    async: false,
                    success: function(data, textStatus, jqXHR)
                    {

                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        alert("Error occured during upload, " + textStatus + errorThrown);
                    }
                });

                e.preventdefault();
                return false;
            });
        </script>

        <h3>---current stored---</h3>
        <table border="1" align="center">
            <tr><th>type</th><th>value</th><th>Link</th><th>date</th></tr>
            <?php
            include_once("../settings/connect.php");
            $query = "SELECT * FROM data WHERE userid = $userid";
            $result = mysqli_query($con, $query);
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><td align=\"center\">" . $row['type'] . "</td>";
                    if ($row['type'] == "text") {
                        echo "<td align=\"center\">" . $row['text'] . "</td><td>N/A</td>";
                    } else {
                        echo "<td align=\"center\">" . $row['text'] . "</td><td><a href=\"" . $row['url'] . "\">Download</a></td>";
                        //TODO add other file type support
                    }
                    echo "<td align=\"center\">" . $row['date'] . "</td></tr>";
                }
            }
            ?>
        </table>
    </center>
    </font>
</body>
</html>