<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Faire comprendre au navigateur ce qu'on lui répond :
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    include("db.php");


    // Lève l'ambiguïté sur le driver à utiliser
    $connexion = new PDO("mysql:host=".$url."; dbname=chat", $user, $pass); 
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $req = "SELECT 0 as PostId, message_id as id, pseudo as name, email, message as body 
            FROM messages m JOIN utilisateurs u ON u.id = m.utilisateur_id
            WHERE conversation = :conv
            "; 

    try {
        $statment = $connexion->prepare($req);
        $param = $_GET["conversation"];
        $statment->execute(["conv" => $param]);
        $resultats = $statment->fetchAll(PDO::FETCH_ASSOC);
    } catch(Exception $exception) {
        echo $exception->getMessage(); 
    }
    echo json_encode($resultats);
