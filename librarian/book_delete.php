<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/config/init.php";
    
    $user = new User();
    if (!$user -> Is_Logged_in() && !$user -> Is_Admin()) {
        Redirect(location: BASE_URL);
    }

    $book = new Book();
    
    $request = new Request_Validate($_GET, ["id", "token",]);

    $request -> CSRF($_GET["token"]);
    $id = $request -> DigitField($_GET["id"]);

    unset($_SESSION["csrf_token"]);

    if (!empty($book -> List($id))) {
        $book -> Delete($id);
        Redirect("Book has been deleted", "books.php");
    }
    else {
        Redirect("Invalid ID", "books.php");
    }
    