<?php
session_start();

require "db.php";
require "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$client = new Google_Client();
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri("http://localhost/to_do_list_project/google-login.php");

$client->addScope("email");
$client->addScope("profile");

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    $oauth = new Google_Service_Oauth2($client);
    $userInfo = $oauth->userinfo->get();

    $email = $userInfo->email;
    $name = $userInfo->name;

    // Vérifier si user existe
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        // créer utilisateur
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, '')");
        $stmt->execute([$name, $email]);
    }
    $_SESSION["nom"] = $name;
    $_SESSION["email"] = $email;

    header("Location: dashboard.php");
    exit;
}
?>