<?php
    session_start();
    // Check if logged in
    if(!isset($_SESSION["loggedin"])||$_SESSION["loggedin"]!==true){
        header("Location: admin-login.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        #explorer,#editor{
            height: 50vh;
            width: 100vw;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div id="explorer">
        <div id="table_listing">
            <?php
            //session_destroy();
            $db = new mysqli("localhost",$_SESSION["login"],$_SESSION["password"],"kino");
            $result  = $db->query("SELECT * FROM films");
            if ($result->num_rows > 0) {
                // Fetch and print all rows
                while($row = $result->fetch_assoc()) {
                    echo "Id: " . $row["Id"]. " - Title: " . $row["Title"]. " - Director: " . $row["Director"]. " - Length: " . $row["Length"]. "<br>";
                }
            } else {
                echo "0 results";
            }
            ?>
        </div>
        <div id="table_data">

        </div>
    </div>
    <div id="editor">

    </div>
</body>
</html>