<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    die(json_encode(["error" => "authentification required"]));
    exit;
}

if (!isset($_GET["id_categorie"])) {
    die(json_encode(["error" => "id_categorie parameter needed"]));
    exit;
}

$id_categorie = $_GET["id_categorie"];
$id_utilisateur = $_SESSION["user_id"];

require "../model/model.php";

if(!categorieAppartientA($id_utilisateur, $id_categorie)){
    http_response_code(403);
    die(json_encode(["error" => "categorie does not belong to you"]));
    exit;
}

$flux_rss = getFluxRSSInsideCategorie($id_categorie);
die(json_encode(["flux_rss" => $flux_rss]));
