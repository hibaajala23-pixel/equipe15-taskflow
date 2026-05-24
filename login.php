<?php
session_start();

require "db.php";
require "vendor/autoload.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $sql = "SELECT * FROM users WHERE email = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);

    $user = $stmt->fetch();

    // Email incorrect
    if (!$user) {

        $_SESSION["error"] = "This email does not exist";

        header("Location: hibaindex.php");
        exit();
    }

    // Mot de passe incorrect
    elseif (!password_verify($password, $user["password"])) {

        $_SESSION["error"] = "Incorrect password";

        header("Location: hibaindex.php");
        exit();
    }

    // Succès
    else {

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["name"];

        header("Location: dashboard.php");
        exit();
    }
}
?>