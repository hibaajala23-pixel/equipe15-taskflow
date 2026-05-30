<?php
// forgot_password.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);

    if (empty($email)) {

        $message = "Please enter your email.";

    } else {

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

            // Vérifier email

            $sql = "SELECT * FROM users WHERE email = ?";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([$email]);

            $userData = $stmt->fetch();

            if ($userData) {

                // ===== TOKEN =====

                $token = bin2hex(random_bytes(32));

                $expires = date(
                    "Y-m-d H:i:s",
                    strtotime("+1 hour")
                );

                // Sauvegarder token

                $update = $pdo->prepare("
                    UPDATE users
                    SET reset_token = ?,
                        reset_expires = ?
                    WHERE email = ?
                ");

                $update->execute([
                    $token,
                    $expires,
                    $email
                ]);

                // ===== RESET LINK =====

                $resetLink =
                "http://localhost/to_do_list_project/reset_password.php?token="
                . $token;

                // ===== SEND EMAIL =====

                $mail = new PHPMailer(true);

                try {

                    $mail->isSMTP();

                    $mail->Host = 'smtp.gmail.com';

                    $mail->SMTPAuth = true;

                    // TON EMAIL GMAIL
                    $mail->Username = 'h.chrorou@gmail.com';

                    // TON APP PASSWORD GOOGLE
                    $mail->Password = 'nphx bouz qryd hakj';

                    $mail->SMTPSecure =
                    PHPMailer::ENCRYPTION_STARTTLS;

                    $mail->Port = 587;

                    // Expéditeur

                    $mail->setFrom(
                        'h.chrorou@gmail.com',
                        'TaskFlow'
                    );

                    // Destinataire

                    $mail->addAddress($email);

                    // Email HTML

                    $mail->isHTML(true);

                    $mail->Subject =
                    'Reset Your Password';

                    $mail->Body = "
                        <div style='
                            font-family:Arial;
                            padding:20px;
                        '>

                            <h2 style='color:#19324e;'>
                                Password Reset
                            </h2>

                            <p>
                                We received a request to reset
                                your password.
                            </p>

                            <p>
                                Click the button below:
                            </p>

                            <a href='$resetLink'
                            style='
                                display:inline-block;
                                padding:14px 22px;
                                background:#2563EB;
                                color:white;
                                text-decoration:none;
                                border-radius:10px;
                                font-weight:bold;
                            '>
                                Reset Password
                            </a>

                            <p style='margin-top:25px;'>
                                This link expires in 1 hour.
                            </p>

                        </div>
                    ";

                    $mail->send();

                    $message =
                    "Password reset email sent successfully.";

                } catch (Exception $e) {

                    $message =
                    "Email could not be sent.";
                }

            } else {

                $message =
                "No account found with this email.";
            }

        } catch(PDOException $e) {

            $message = "Database error.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>TaskFlow - Forgot Password</title>

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
}

body{
    font-family:'DM Sans',sans-serif;
    background:linear-gradient(
        135deg,
        #19324e 0%,
        #102844 100%
    );

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

    background:#f4f8ff;

    color:#19324e;

    font-size:14px;

    line-height:1.6;
}

.back{

    display:block;

    text-align:center;

    margin-top:22px;

    color:var(--secondary);

    text-decoration:none;

    font-weight:600;
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

    <h2>Forgot Password</h2>

    <p class="subtitle">
        Enter your email address and we will send
        you a password reset link.
    </p>

    <form method="POST">

        <div class="input-group">

            <label>Email Address</label>

            <input
                type="email"
                name="email"
                placeholder="you@example.com"
                required
            >

        </div>

        <button type="submit">
            Send Reset Link
        </button>

    </form>

    <?php if(!empty($message)): ?>

        <div class="message">

            <?php echo $message; ?>

        </div>

    <?php endif; ?>

    <a href="hibaindex.php" class="back">
        ← Back to Login
    </a>

</div>

</body>
</html>