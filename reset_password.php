<?php
// reset_password.php

$message = "";
$success = false;

// Vérifier si token existe
if (!isset($_GET["token"])) {
    die("Invalid reset link.");
}

$token = $_GET["token"];

// ===== DATABASE =====
$host = "localhost";
$dbname = "taskflow";
$user = "root";
$pass = "";

try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $pass
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifier token
    $sql = "
        SELECT *
        FROM users
        WHERE reset_token = ?
        AND reset_expires > NOW()
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$token]);

    $userData = $stmt->fetch();

    // Token invalide
    if (!$userData) {
        die("This reset link is invalid or expired.");
    }

    // ===== FORM SUBMIT =====
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $password = trim($_POST["password"]);
        $confirm  = trim($_POST["confirm_password"]);

        // Vérifications
        if (empty($password) || empty($confirm)) {

            $message = "Please fill all fields.";

        } elseif (strlen($password) < 6) {

            $message = "Password must be at least 6 characters.";

        } elseif ($password !== $confirm) {

            $message = "Passwords do not match.";

        } else {

            // Hash password
            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            // Update password
            $update = $pdo->prepare("
                UPDATE users
                SET password = ?,
                    reset_token = NULL,
                    reset_expires = NULL
                WHERE id = ?
            ");

            $update->execute([
                $hashedPassword,
                $userData["id"]
            ]);

            $success = true;

            $message = "
                Password updated successfully.<br><br>

                <a href='hibaindex.php'
                style='color:#2563EB;font-weight:bold;text-decoration:none;'>
                Go to Login
                </a>
            ";
        }
    }

} catch(PDOException $e) {

    die("Database error.");

}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>TaskFlow - Reset Password</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

:root{
    --primary:#19324e;
    --secondary:#2563EB;
    --white:#ffffff;
    --light:#f4f7fa;
    --border:#dbe4ef;
    --text:#0f1923;
    --muted:#7d8b99;
    --error:#e04545;
    --success:#16a34a;
}

body{
    font-family:'DM Sans',sans-serif;
    background:linear-gradient(135deg,#19324e 0%, #102844 100%);
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}

.card{
    width:100%;
    max-width:430px;
    background:white;
    border-radius:30px;
    padding:45px;
    box-shadow:0 25px 60px rgba(0,0,0,0.2);
    animation:fadeUp .8s ease;
}

h2{
    font-family:'Sora',sans-serif;
    font-size:32px;
    color:var(--text);
    margin-bottom:12px;
}

.subtitle{
    color:var(--muted);
    margin-bottom:30px;
    line-height:1.6;
}

.input-group{
    margin-bottom:22px;
}

label{
    display:block;
    margin-bottom:8px;
    font-size:14px;
    font-weight:600;
    color:#445566;
}

.input-wrap{
    position:relative;
}

input{
    width:100%;
    padding:15px 18px;
    border-radius:16px;
    border:1.5px solid var(--border);
    background:var(--light);
    font-size:15px;
    outline:none;
    transition:.2s;
}

input:focus{
    border-color:var(--secondary);
    background:white;
    box-shadow:0 0 0 4px rgba(37,99,235,0.12);
}

button{
    width:100%;
    padding:16px;
    border:none;
    border-radius:18px;
    background:var(--primary);
    color:white;
    font-size:15px;
    font-weight:700;
    cursor:pointer;
    transition:.25s;
}

button:hover{
    transform:translateY(-2px);
    background:#24476d;
}

.message{
    margin-top:25px;
    padding:16px;
    border-radius:16px;
    font-size:14px;
    line-height:1.6;
}

.error{
    background:#fff1f1;
    color:var(--error);
}

.success{
    background:#f0fff4;
    color:var(--success);
}

.back{
    display:block;
    text-align:center;
    margin-top:22px;
    color:var(--secondary);
    text-decoration:none;
    font-weight:600;
}

.pw-toggle{
    position:absolute;
    right:16px;
    top:50%;
    transform:translateY(-50%);
    cursor:pointer;
    color:#7d8b99;
    user-select:none;
    font-size:14px;
}

@keyframes fadeUp{

    from{
        opacity:0;
        transform:translateY(25px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }
}

</style>
</head>
<body>

<div class="card">

    <h2>Reset Password</h2>

    <p class="subtitle">
        Enter your new password below.
    </p>

    <?php if(!$success): ?>

    <form method="POST">

        <div class="input-group">

            <label>New Password</label>

            <div class="input-wrap">

                <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Enter new password"
                    required
                >

                <span class="pw-toggle" onclick="togglePassword('password')">
                    Show
                </span>

            </div>

        </div>

        <div class="input-group">

            <label>Confirm Password</label>

            <div class="input-wrap">

                <input
                    type="password"
                    name="confirm_password"
                    id="confirm_password"
                    placeholder="Confirm new password"
                    required
                >

                <span class="pw-toggle" onclick="togglePassword('confirm_password')">
                    Show
                </span>

            </div>

        </div>

        <button type="submit">
            Reset Password
        </button>

    </form>

    <?php endif; ?>

    <?php if(!empty($message)): ?>

        <div class="message <?php echo $success ? 'success' : 'error'; ?>">

            <?php echo $message; ?>

        </div>

    <?php endif; ?>

    <a href="hibaindex.php" class="back">
        ← Back to Login
    </a>

</div>

<script>

function togglePassword(id){

    const input = document.getElementById(id);

    input.type =
        input.type === "password"
        ? "text"
        : "password";
}

</script>

</body>
</html>