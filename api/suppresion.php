<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    die(json_encode(["error" => "authentification required"]));
    exit;
}

if (!(isset($_GET["id_categorie"]) xor isset($_GET["id_espace"]))) {
    http_response_code(400);
    die(json_encode(["error" => "id_categorie or id_espace parameter needed"]));
    exit;
}

require "../model/model.php";

$id_utilisateur = $_SESSION["user_id"];

if (isset($_GET["id_categorie"])) {

    $id_categorie = $_GET["id_categorie"];

    if (!categorieAppartientA($id_utilisateur, $id_categorie)) {
        http_response_code(403);
        die(json_encode(["error" => "categorie does not belong to you"]));
        exit;
    }

    deleteCategorie($id_categorie);

    die(json_encode(["success" => "Successfully deleted categorie"]));
    exit;
}

$id_espace = $_GET["id_espace"];

if (!espaceAppartientA($id_utilisateur, $id_espace)) {
    http_response_code(403);
    die(json_encode(["error" => "espace does not belong to you"]));
    exit;
}

deleteEspace($id_espace);

die(json_encode(["success" => "Successfully deleted espace"]));
exit;
