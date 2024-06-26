<?php

session_start();

$id_invitation = $_GET["id_invitation"];
$id_utilisateur = $_SESSION["user_id"];

if (!isset($id_utilisateur)) {
    http_response_code(401);
    die(json_encode(["error" => "authentification required"]));
    exit;
}

if (!isset($id_invitation)) {
    http_response_code(400);
    die(json_encode(["error" => "id_invitation parameter needed"]));
    exit;
}

require "../model/model.php";

if(!invitationAppartientA($id_utilisateur, $id_invitation)){
    http_response_code(403);
    die(json_encode(["error" => "invitation does not belong to you"]));
    exit;
}

accepterInvitation($id_invitation);
header("Location: ../index.php");