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

$user_id = $_SESSION['user_id'];

/*
|--------------------------------------------------------------------------
| GET TASK ID
|--------------------------------------------------------------------------
*/
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$task_id = $_GET['id'];

/*
|--------------------------------------------------------------------------
| UPDATE TASK
|--------------------------------------------------------------------------
*/
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $categorie_id = $_POST['categorie_id'];
    $date_limite = $_POST['date_limite'];
    $priorite = $_POST['priorite'];
    

   $sql = "UPDATE tasks 
        SET titre = :titre,
            description = :description,
            categorie_id = :categorie_id,
            date_limite = :date_limite,
            priorite = :priorite
        WHERE id = :id AND user_id = :user_id";

    $stmt = $pdo->prepare($sql);

$stmt->execute([
    ':titre' => $titre,
    ':description' => $description,
    ':categorie_id' => $categorie_id,
    ':date_limite' => $date_limite,
    ':priorite' => $priorite,
    ':id' => $task_id,
    ':user_id' => $user_id
]);

    header("Location: dashboard.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| FETCH TASK DATA
|--------------------------------------------------------------------------
*/
$sql = "SELECT * FROM tasks WHERE id = :id AND user_id = :user_id";
$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':id' => $task_id,
    ':user_id' => $user_id
]);

$task = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    header("Location: dashboard.php");
    exit();
}
?>

<!-- 🔥 TON DESIGN ORIGINAL STRICTEMENT INCHANGÉ -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TaskFlow — Edit Task</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet" />

  <style>
    /* TON CSS EXACTEMENT TEL QUEL (aucun changement) */

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --navy-deep:   #0a1e35;
      --navy-mid:    #0e3460;
      --teal-accent: #1a7fbe;
      --sky-bright:  #2aa8e0;
      --white:       #ffffff;
      --off-white:   #f7f9fc;
      --text-dark:   #0f1923;
      --text-muted:  #8a96a3;
      --border:      #e2e8ef;
      --error:       #e04545;
      --input-bg:    #f4f7fa;
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background-color: var(--off-white);
      color: var(--text-dark);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }

    .container {
      width: 100%;
      max-width: 550px;
      background: var(--white);
      border-radius: 16px;
      padding: 40px;
      box-shadow: 0 10px 30px rgba(10, 30, 53, 0.05);
      animation: fadeIn 0.5s ease both;
    }

    .header { margin-bottom: 32px; text-align: center; }
    .header h2 {
      font-family: 'Sora', sans-serif;
      font-size: 28px;
      font-weight: 800;
      color: var(--navy-deep);
      letter-spacing: -.5px;
      margin-bottom: 6px;
    }
    .header p { font-size: 14px; color: var(--text-muted); }

    .field { margin-bottom: 22px; }
    .field label {
      display: block;
      font-size: 13.5px;
      font-weight: 700;
      font-family: 'Sora', sans-serif;
      color: var(--navy-mid);
      margin-bottom: 8px;
    }

    .input-wrap input,
    .input-wrap textarea,
    .input-wrap select {
      width: 100%;
      padding: 14px 16px;
      background: var(--input-bg);
      border: 1.5px solid transparent;
      border-radius: 12px;
      font-family: 'DM Sans', sans-serif;
      font-size: 14.5px;
      color: var(--text-dark);
      outline: none;
      transition: border-color .2s, background .2s, box-shadow .2s;
    }

    .input-wrap textarea { resize: vertical; min-height: 100px; }

    .input-wrap input:focus,
    .input-wrap textarea:focus,
    .input-wrap select:focus {
      background: var(--white);
      border-color: var(--teal-accent);
      box-shadow: 0 0 0 3px rgba(26,127,190,.12);
    }

    .row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

    .actions { display: flex; gap: 12px; margin-top: 32px; }

    .btn {
      flex: 1; padding: 14px; border-radius: 12px;
      font-family: 'Sora', sans-serif; font-size: 15px; font-weight: 700;
      cursor: pointer; transition: all 0.2s ease; text-align: center;
    }

    .btn-cancel { background: transparent; border: 1.5px solid var(--border); color: var(--text-muted); }
    .btn-cancel:hover { background: var(--input-bg); color: var(--text-dark); }

    .btn-submit {
      background: linear-gradient(135deg, var(--navy-mid) 0%, var(--teal-accent) 100%);
      border: none; color: var(--white);
    }

  </style>
</head>

<body>

<div class="container">

  <div class="header">
    <h2>Edit Task</h2>
    <p>Modify the details of your project task</p>
  </div>

  <!-- 🔥 FORM CONNECTÉ À PHP -->
  <form method="POST">

    <div class="field">
      <label>Task Title</label>
      <div class="input-wrap">
        <input type="text" name="titre" value="<?= htmlspecialchars($task['titre']) ?>" required />
      </div>
    </div>

    <div class="field">
      <label>Description</label>
      <div class="input-wrap">
        <textarea name="description" required><?= htmlspecialchars($task['description']) ?></textarea>
      </div>
    </div>

    <div class="field">
      <label>Category</label>
      <div class="input-wrap">
        <select name="categorie_id">
          <option value="1">📝 Work</option>
          <option value="2">🏠 Personal</option>
          <option value="3">🎯 Goals</option>
          <option value="4">🛒 Shopping</option>
        </select>
      </div>
    </div>

    <div class="row">

      <div class="field">
        <label>Due Date</label>
        <div class="input-wrap">
          <input type="date" name="date_limite" value="<?= $task['date_limite'] ?>" />
        </div>
      </div>

      <div class="field">
        <label>Priority</label>
        <div class="input-wrap">
          <select name="priorite">
            <option value="Faible" <?= $task['priorite']=="Faible"?'selected':'' ?>>🟢 Low</option>
            <option value="Moyenne" <?= $task['priorite']=="Moyenne"?'selected':'' ?>>🟡 Medium</option>
            <option value="Haute" <?= $task['priorite']=="Haute"?'selected':'' ?>>🔴 High</option>
          </select>
        </div>
      </div>

    </div>

  

    <div class="actions">
      <button type="button" class="btn btn-cancel" onclick="window.history.back()">Cancel</button>
      <button type="submit" class="btn btn-submit">Save Changes</button>
    </div>

  </form>

</div>

</body>
</html>