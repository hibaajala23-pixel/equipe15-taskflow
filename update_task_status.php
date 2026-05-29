<?php
require "db.php";

if(isset($_POST['id']) && isset($_POST['is_done'])){

    $id = $_POST['id'];
    $is_done = $_POST['is_done'];

    $sql = "UPDATE tasks SET is_done = :is_done WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':is_done' => $is_done,
        ':id' => $id
    ]);
}
?>