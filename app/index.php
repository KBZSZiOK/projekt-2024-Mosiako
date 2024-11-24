<?php
    session_start();

    if(isset($_POST["go_to"])){$_SESSION["page"] = $_POST["go_to"];}
    if(!isset($_SESSION["page"])){$_SESSION["page"]="films";}
    if($_SESSION["page"]=="films" && isset($_POST["selected_film"])){$_SESSION["page"]="film";}
    if($_SESSION["page"]=="film" && !isset($_POST["selected_film"])){$_SESSION["page"]="films" ;}
    if($_SESSION["page"]=="films" && !isset($_SESSION["films_page"])){$_SESSION["films_page"] = 1;}
    if($_SESSION["page"]=="sessions" && !isset($_SESSION["sessions_page"])){$_SESSION["sessions_page"] = 1;}
    if(isset($_POST["page_select"]) && $_SESSION["page"]=="films" ){
        switch ($_POST["page_select"]) {
            case '+':
                $_SESSION["films_page"] += 1;
                break;
            case '-':
                $_SESSION["films_page"] -= 1;
                break;
        }
    }
    if(isset($_POST["page_select"]) && $_SESSION["page"]=="sessions" ){
        switch ($_POST["page_select"]) {
            case '+':
                $_SESSION["sessions_page"] += 1;
                break;
            case '-':
                $_SESSION["sessions_page"] -= 1;
                break;
        }
    }
    //var_dump($_SESSION);
    //print_r($_POST);
    //helper functions
    function makeDBRequest($request){
        $result = [];
        $db = new mysqli("localhost","admin","zaq1@WSX","kino");
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


//content generation
    function generate_films_content(){
        $location = '';
        $results_per_page = 3;

        if(!($_SESSION["films_page"] > 1)){ // check if first
            $location = 'first';
            $_SESSION["films_page"] = 1;
            $page = 1;
        }else{
            $page = $_SESSION["films_page"] ;
        }
        $films = makeDBRequest(sprintf("SELECT * FROM films ORDER BY `Id` OFFSET %d ROWS FETCH NEXT %d ROWS ONLY",($page-1) * $results_per_page,$results_per_page));
        if (empty($films)) { // check if out of bounds
            $location = 'last';
            $page -= 1;
            $_SESSION["films_page"] = $page;
            $films = makeDBRequest(sprintf("SELECT * FROM films ORDER BY `Id` OFFSET %d ROWS FETCH NEXT %d ROWS ONLY", ($page - 1) * $results_per_page,$results_per_page));
        }
        if(count($films)!=$results_per_page || empty(makeDBRequest(sprintf("SELECT * FROM films ORDER BY `Id` OFFSET %d ROWS FETCH NEXT %d ROWS ONLY", ($page) * $results_per_page,$results_per_page)))){ // check if last
            $location = 'last';
        }

        $html = "";
        foreach ($films as $key => $value) {
            $html .= sprintf("<div class='film_entry_container'>
                                    <img src='' alt=''>
                                    <h3>%s</h3>
                                    <div>
                                        <p><span> Czas trwania: </span><span> %d min</span></p>
                                        <span> Reżyser: </span><span>%s</span>
                                        <form method='POST'><input type='hidden' name='selected_film' value='%s'><input type='submit' value='przejdz do filmu'></form>
                                    </div>
                                </div>",$value["Title"],$value["Length"],$value["Director"],$value["Id"]);
        }
        //change page buttons
        $html .= "<div id='navigation_container'>";
        if($location != 'first'){ $html .= "<form method='POST' class='menu_button'><input type='hidden' name='page_select' value='-'><input type='submit' value='<<'></form>";}
        if($location != 'last'){ $html .= "<form method='POST' class='menu_button'><input type='hidden' name='page_select' value='+'><input type='submit' value='>>'></form>";}
        $html .="</div>";
        return $html;
    }

    function generate_film_content(){
        $film = makeDBRequest(sprintf("SELECT * FROM films WHERE Id = %d", $_POST["selected_film"]))[0];
        $film_types = makeDBRequest(sprintf("SELECT film_type.Name FROM `type_film`, `film_type` WHERE type_film.Type_Id = film_type.Id AND type_film.Film_Id = %d", $_POST["selected_film"]));
        $sessions = makeDBRequest(sprintf("SELECT sessions.Term FROM sessions, films WHERE sessions.Film_Id = films.Id AND films.Id = %d", $_POST["selected_film"]));
        printf("<h1>%s</h1><br><h2>Gatunki:</h2>",$film["Title"]);
        if (!empty($film_types)){
        foreach ($film_types as $key => $value) {
            echo $value["Name"] . "<br>";
        }}
        printf("<h2>Daty wyświetlania:</h2>");
        if (!empty($sessions)){
        foreach ($sessions as $key => $value) {
            echo $value["Term"] . "<br>";
        }}
        printf("<h2>Długość:</h2>%s min",$film["Length"]);
    }

    function generate_sessions_content() {
        $location = '';
        $results_per_page = 3;
    
        if (!($_SESSION["sessions_page"] > 1)) { // Check if on the first page
            $location = 'first';
            $_SESSION["sessions_page"] = 1;
            $page = 1;
        } else {
            $page = $_SESSION["sessions_page"];
        }
    
        // Query to fetch sessions with pagination
        $sessions = makeDBRequest(sprintf(
            "SELECT s.Id AS Session_Id, s.Term, s.Empty_seat_count, f.Title, f.Length, f.Director 
             FROM sessions s
             JOIN films f ON s.Film_Id = f.Id
             ORDER BY s.Id
             OFFSET %d ROWS FETCH NEXT %d ROWS ONLY",
            ($page - 1) * $results_per_page,
            $results_per_page
        ));
    
        if (empty($sessions)) { // Check if out of bounds
            $location = 'last';
            $page -= 1;
            $_SESSION["sessions_page"] = $page;
            $sessions = makeDBRequest(sprintf(
                "SELECT s.Id AS Session_Id, s.Term, s.Empty_seat_count, f.Title, f.Length, f.Director 
                 FROM sessions s
                 JOIN films f ON s.Film_Id = f.Id
                 ORDER BY s.Id
                 OFFSET %d ROWS FETCH NEXT %d ROWS ONLY",
                ($page - 1) * $results_per_page,
                $results_per_page
            ));
        }
    
        if (count($sessions) != $results_per_page || empty(makeDBRequest(sprintf(
            "SELECT s.Id FROM sessions s ORDER BY s.Id OFFSET %d ROWS FETCH NEXT %d ROWS ONLY",
            $page * $results_per_page,
            $results_per_page
        )))) { // Check if on the last page
            $location = 'last';
        }
    
        $html = "";
        foreach ($sessions as $session) {
            $html .= sprintf(
                "<div class='session_entry_container'>
                    <div>
                        <p><span> Tytuł: </span><span> %s</span></p>
                        <p><span> Czas trwania: </span><span> %d min</span></p>
                        <p><span> Reżyser: </span><span>%s</span></p>
                        <p><span> Termin: </span><span>%s</span></p>
                        <p><span> Dostępne miejsca: </span><span>%d</span></p>
                    </div>
                </div>",
                htmlspecialchars($session["Title"]),
                $session["Length"],
                htmlspecialchars($session["Director"]),
                $session["Term"],
                $session["Empty_seat_count"],
                $session["Session_Id"]
            );
        }
    
        // Navigation buttons
        $html .= "<div id='navigation_container'>";
        if ($location != 'first') {
            $html .= "<form method='POST' class='menu_button'>
                        <input type='hidden' name='page_select' value='-'>
                        <input type='submit' value='<<'>
                      </form>";
        }
        if ($location != 'last') {
            $html .= "<form method='POST' class='menu_button'>
                        <input type='hidden' name='page_select' value='+'>
                        <input type='submit' value='>>'>
                      </form>";
        }
        $html .= "</div>";
    
        return $html;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic Layout</title>
    <link rel="stylesheet" href="./index.css">
    <link rel="stylesheet" href="./subpages.css">
    <link rel="stylesheet" href="./scrolling-text.css">
</head>
<body>

    <header>
        <h1>KINO</h1>
        <div id="scrolling_text">
            <div></div>
        </div>
    </header>
    <div div id= "menu">
        <div id="menu_content_container">
        <form method='POST' class='menu_button'><input type='hidden' name='go_to' value='films'><input type='submit' value='Filmy'></form>
        <form method='POST' class='menu_button'><input type='hidden' name='go_to' value='panel'><input type='submit' value='Panel administracyjny'></form>
        <form method='POST' class='menu_button'><input type='hidden' name='go_to' value='sessions'><input type='submit' value='Seanse'></form>
        </div>
        <div id="menu_button_container"><button id="menu_toggle"></button></div>
    </div>
   
    <main>
        <?php
            if($_SESSION["page"] == "films"){echo generate_films_content();}
            if($_SESSION["page"] == "film"){echo generate_film_content();}
            if($_SESSION["page"] == "sessions"){echo generate_sessions_content();}
            if($_SESSION["page"] == "panel"){
                header("Location: admin-panel.php");
            }
        ?>
    </main>
    <footer>
        <p>&copy; 2024</p>
    </footer>

</body>
<script src="./index.js"></script>
</html>
