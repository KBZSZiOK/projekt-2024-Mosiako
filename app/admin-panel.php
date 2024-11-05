<?php
    //sorting tables
    //deleting buttons
    //fix highlighting]

    session_start();
    // Check if logged in
    if(!isset($_SESSION["loggedin"])||$_SESSION["loggedin"]!==true){
        header("Location: admin-login.php");
        exit;
    }

    if(isset($_POST["selected_table_listing"])){
        $_SESSION["selected_table_listing"]=$_POST["selected_table_listing"];
    }
    //set defaults
    if(isset($_POST["operation_type"])){$_SESSION["operation_type"]=$_POST["operation_type"];}else{if(!isset($_SESSION["operation_type"])){$_SESSION["operation_type"]="add";}}
    if(isset($_POST["operation_sent"])){$_SESSION["operation_sent"]=$_POST["operation_sent"];}else{if(!isset($_SESSION["operation_sent"])){$_SESSION["operation_sent"]=false;}}
    $_SESSION["selected_table_editor"] = $_SESSION["selected_table_listing"];
    //check for operation
    if($_SESSION["operation_sent"] == 1){
        $_SESSION["operation_sent"] = 0;
        //get columns of the table selected
        $columns = (makeDBRequest("SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '".getTableNameFromId($_SESSION["selected_table_editor"])."' AND TABLE_SCHEMA = 'kino';"));
        //create column names for the query
        $column_names_for_query = "";
        foreach ($columns as $key => $value) {
            if(($value["COLUMN_NAME"] !== "Id")){$column_names_for_query.=$value["COLUMN_NAME"].",";}
        }
        $column_names_for_query = rtrim($column_names_for_query, ",");
        //create query headrer
        $query_to_send = sprintf("INSERT INTO %s (%s) VALUES",getTableNameFromId($_SESSION["selected_table_editor"]),$column_names_for_query);
        //check validity of the data and add it into the query
        $recognized_data_types = 0;
        $query_to_send .= "(";
        echo"<br> columns: ";print_r($columns); echo"<br>";
        print_r($_POST);
        $i = 1;
        foreach ($_POST as $key => $value) {
            if($key != "operation_sent" && isset($_POST[$key])){ // skip 1st element as its from operation_sent
                $recognized_data_types+=1;
                if($columns[$i]["DATA_TYPE"] == "int" || $columns[$i]["DATA_TYPE"] === "bigint"){
                    $query_to_send .= $value.",";
                }
                elseif($columns[$i]["DATA_TYPE"] == "datetime"){
                    //      2024-11-05T13:26
                    //      2024-10-26 21:00:00
                    $value = explode("T",$value);
                    $value = implode(" ",$value);
                    $query_to_send .= "'".$value.":00',";
                }
                elseif($columns[$i]["DATA_TYPE"] == "varchar"){
                    $query_to_send .= "'".$value."',";
                }
                else{
                    echo $key." is unknown type ". $columns[$i]["DATA_TYPE"];
                    $recognized_data_types-=1;
                }
                $i ++;
            }
        }
        $query_to_send = rtrim($query_to_send, ",");
        $query_to_send .= ");";
        printf("%s  %.2f",count($columns)-1,$recognized_data_types);
        if (count($columns)-1 == $recognized_data_types){
            //make query
            //echo "query:        ".$query_to_send;
            makeDBRequest($query_to_send);
        }else{
            echo "incorrect amount of data";
        }
    }
    //db functions
    function makeDBRequest($request){
        $result = [];
        $db = new mysqli("localhost",$_SESSION["login"],$_SESSION["password"],"kino");
        $query_result  = $db->query($request);
        if(!isset($query_result->num_rows)){
            return -1;
        }
        if ($query_result->num_rows > 0) {
            while($row = $query_result->fetch_assoc()) {
                $result[] = $row;
            }
        } else {
            $db->close();
            return null;
        }
        $db->close();
        return $result;
    }
    function arrayToHtmlTable($data) {
        if (empty($data) || !is_array($data)) {
            return "<p>No data available</p>";
        }
        $html = "<table cellpadding='5' cellspacing='0'>";
        $headers = array_keys($data[0]);
    
        // generate headers
        $html .= "<tr>";
        foreach ($headers as $header) {
            $html .= "<th>" . htmlspecialchars($header) . "</th>";
        }
        $html .= "</tr>";
    
        // generate the table rows
        foreach ($data as $row) {
            $html .= "<tr>";
            foreach ($row as $key => $value) {
                $html .= "<td>" . htmlspecialchars($value) . "</td>";
            }
            $html .= "</tr>";
        }
        $html .= "</table>";
    
        echo $html;
    }  
    function arrayAddToForm($data){
        $html = "<form method='POST'><input type='submit' style='margin-bottom:1cm'><br>";
        $type = "";
        foreach ($data as $key => $value) {
            if($value["COLUMN_NAME"] != "Id"){
                if($value["DATA_TYPE"] == "bigint" or $value["DATA_TYPE"] == "int"){
                    $type = "number";
                }
                elseif($value["DATA_TYPE"] == "varchar"){
                    $type = "text";
                }
                elseif($value["DATA_TYPE"] == "datetime"){
                    $type = "datetime-local";
                }
                $html .= sprintf("<label for='%s' class='label'> %s </label>",$value["COLUMN_NAME"],$value["COLUMN_NAME"]);
                $html .= sprintf("<input type='%s' name='%s' id='%s'>",$type,$value["COLUMN_NAME"],$value["COLUMN_NAME"]);
            }
            $html .= sprintf("<input type='hidden' name='operation_sent' value=1>",$type,$value["COLUMN_NAME"],$value["COLUMN_NAME"]);
            //echo $value["COLUMN_NAME"]." ".$value["DATA_TYPE"];
        }
        $html .= "</form>";
        echo $html;
    }
    function arrayEditToForm($data){
        // $html = "<form>";
        // $type = "";
        // foreach ($data as $key => $value) {
        //     if($value["COLUMN_NAME"] != "Id"){
        //         if($value["DATA_TYPE"] == "bigint" or $value["DATA_TYPE"] == "int"){
        //             $type = "number";
        //         }
        //         elseif($value["DATA_TYPE"] == "varchar"){
        //             $type = "text";
        //         }
        //         $html .= sprintf("<label for='%s' class='label'> %s </label>",$value["COLUMN_NAME"],$value["COLUMN_NAME"]);
        //         $html .= sprintf("<input type='%s' name='%s' id='%s'>",$type,$value["COLUMN_NAME"],$value["COLUMN_NAME"]);
        //     }
        //     //echo $value["COLUMN_NAME"]." ".$value["DATA_TYPE"];
        // }
        // $html .= "<input type='submit'></form>";
        // echo $html;
    }
    function getTableNameFromId($id){
        $tablename = "films";
        switch ($id) {
            case 0:
                $tablename = "films"; break;
            case 1:
                $tablename = "rooms"; break;
            case 2:
                $tablename = "film_type"; break;
            case 3:
                $tablename = "sessions"; break;
            case 4:
                $tablename = "clients"; break;
            case 5:
                $tablename = "sellers"; break;
            case 6:
                $tablename = "tickets"; break;
            default:
                $tablename = "films";
        }
        return $tablename;
    }
    function displayHTMLTable($id){
        
        $request = [];
        switch ($id) {
            case 0:
                $request[] = "SELECT * FROM films ";
                $request[] = "Filmy"; break;
            case 1:
                $request[] = "SELECT rooms.ID, rooms.Seat_count AS 'liczba miejsc' FROM rooms";
                $request[] = "Sale"; break;
            case 2:
                $request[] = "SELECT * FROM film_type ";
                $request[] = "Typy filmów"; break;
            case 3:
                $request[] = "SELECT sessions.ID, sessions.Term AS 'data seansu', sessions.Empty_seat_count AS 'liczba wolnych miejsc', films.Title AS 'tytuł filmu', rooms.Seat_count AS 'liczba miejsc' FROM rooms,sessions,films WHERE sessions.Film_Id = films.Id AND sessions.Room_Id = rooms.ID ORDER BY sessions.ID";
                $request[] = "Seanse"; break;
            case 4:
                $request[] = "SELECT * FROM clients ";
                $request[] = "Klienci"; break;
            case 5:
                $request[] = "SELECT * FROM sellers ";
                $request[] = "Sprzedawcy"; break;
            case 6:
                $request[] = "SELECT tickets.ID, sessions.Term AS `data seansu`, films.Title AS `tytuł filmu`, sellers.Name AS `imię sprzedawcy`, sellers.Surname AS `nazwisko sprzedawcy`, clients.Name AS `imię klienta`, clients.Surname AS `nazwisko klienta`, tickets.Price AS `cena` FROM tickets,sessions,sellers,clients,films WHERE tickets.Session_Id = sessions.Id AND sessions.Film_Id = films.Id AND tickets.Seller_Id = sellers.Id AND tickets.Client_Id = clients.Id ORDER BY tickets.ID";
                $request[] = "Bilety"; break;
            default:
                $request[] = "SELECT * FROM films ";
                $request[] = "Filmy";
        }
        printf("<h2>%s</h2>",$request[1]);
        arrayToHtmlTable(makeDBRequest($request[0]));
    }
    function displayTableEditor($tablename){
        $columns = (makeDBRequest("SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '".$tablename."' AND TABLE_SCHEMA = 'kino';"));
        if($_SESSION["operation_type"] == "add"){arrayAddToForm($columns);}
        else if($_SESSION["operation_type"] == "edit"){arrayEditToForm($columns);}
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="./admin-panel-style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title> 
</head>
<body>
    <h1> PANEL ADMINISTRACYJNY</h1><hr>
    <?php //print_r($_SESSION); ?><br>
    <div id="explorer">
        <div id="table_listing">
            <h2 class="admin_panel_header">TABELE</h2>
            <form method="POST"> <input type="hidden" name="selected_table_listing" value=0> <input type="submit" value="Filmy"<?php if(isset($_SESSION["selected_table_listing"])) {if($_SESSION["selected_table_listing"] == 0){echo "style='border:1px white solid;'" ;}} ?>> </form>
            <form method="POST"> <input type="hidden" name="selected_table_listing" value=1> <input type="submit" value="Sale"<?php if(isset($_SESSION["selected_table_listing"])) {if($_SESSION["selected_table_listing"] == 1){echo "style='border:1px white solid;'" ;}} ?>> </form>
            <form method="POST"> <input type="hidden" name="selected_table_listing" value=2> <input type="submit" value="Typy filmów"<?php if(isset($_SESSION["selected_table_listing"])) {if($_SESSION["selected_table_listing"] == 2){echo "style='border:1px white solid;'" ;}} ?>> </form>
            <form method="POST"> <input type="hidden" name="selected_table_listing" value=3> <input type="submit" value="Seanse"<?php if(isset($_SESSION["selected_table_listing"])) {if($_SESSION["selected_table_listing"] == 3){echo "style='border:1px white solid;'" ;}} ?>> </form>
            <form method="POST"> <input type="hidden" name="selected_table_listing" value=4> <input type="submit" value="Klienci"<?php if(isset($_SESSION["selected_table_listing"])) {if($_SESSION["selected_table_listing"] == 4){echo "style='border:1px white solid;'" ;}} ?>> </form>
            <form method="POST"> <input type="hidden" name="selected_table_listing" value=5> <input type="submit" value="Sprzedawcy"<?php if(isset($_SESSION["selected_table_listing"])) {if($_SESSION["selected_table_listing"] == 5){echo "style='border:1px white solid;'" ;}} ?>> </form>
            <form method="POST"> <input type="hidden" name="selected_table_listing" value=6> <input type="submit" value="Bilety"<?php if(isset($_SESSION["selected_table_listing"])) {if($_SESSION["selected_table_listing"] == 6){echo "style='border:1px white solid;'" ;}} ?>> </form>
        </div>
        <div id="table_data">
            <?php

                //check if table to get is set
                if (isset($_SESSION["selected_table_listing"])){
                    displayHTMLTable($_SESSION["selected_table_listing"]);
                }
                else{
                    displayHTMLTable(0);
                }
                
            ?>
        </div>
    </div>
    <hr>
    <div id="editor">
        <div id="editor-menu">
            <form method="POST"> <input type="hidden" name="operation_type" value="add"><input type="submit" value="Dodawanie danych"> </form>
            <form method="POST"> <input type="hidden" name="operation_type" value="alter"><input type="submit" value="Zmiana danych"> </form>
        </div>
        <div id="editor-form">
            <?php
                if (isset($_SESSION["selected_table_editor"])){
                    displayTableEditor(getTableNameFromId($_SESSION["selected_table_editor"]));
                }
                else{
                    displayTableEditor(getTableNameFromId(0));
                }
            ?>
        </div>
    </div>
</body>
</html>