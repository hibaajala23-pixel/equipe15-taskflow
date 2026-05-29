<?php
require "db.php";

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "UPDATE tasks 
            SET is_done = IF(is_done = 1, 0, 1)
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
}

header("Location: dashboard.php");
exit();
?>