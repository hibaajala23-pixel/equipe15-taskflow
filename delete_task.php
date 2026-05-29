<?php
session_start();

require "db.php";

/*
|--------------------------------------------------------------------------
| SECURITY CHECK
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['user_id'])) {
    header("Location: hibaindex.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| CHECK TASK ID
|--------------------------------------------------------------------------
*/

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$task_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

/*
|--------------------------------------------------------------------------
| DELETE TASK (ONLY IF IT BELONGS TO USER)
|--------------------------------------------------------------------------
*/

$sql = "DELETE FROM tasks 
        WHERE id = :id 
        AND user_id = :user_id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':id' => $task_id,
    ':user_id' => $user_id
]);

/*
|--------------------------------------------------------------------------
| REDIRECT BACK TO DASHBOARD
|--------------------------------------------------------------------------
*/

header("Location: dashboard.php");
exit();
?>