<?php
session_start();

require "db.php";

if (
    !isset($_SESSION['user_name']) ||
    !isset($_SESSION['user_id'])
) {

    header("Location: hibaindex.php");
    exit();
}

$userName = $_SESSION['user_name'];
$user_id  = $_SESSION['user_id'];

$sql = "SELECT t.*, c.nom_categorie AS categorie_nom
        FROM tasks t
        LEFT JOIN categories c
        ON t.categorie_id = c.id
        WHERE t.user_id = :user_id
        ORDER BY t.created_at DESC";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':user_id' => $user_id
]);

$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>TaskFlow — Dashboard</title>

<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

:root{
    --navy-deep:#0a1e35;
    --navy-mid:#0e3460;
    --teal-accent:#1a7fbe;
    --white:#ffffff;
    --off-white:#f7f9fc;
    --text-dark:#0f1923;
    --text-muted:#8a96a3;
    --border:#e2e8ef;
    --error:#e04545;
    --input-bg:#f4f7fa;
}

body{
    font-family:'DM Sans',sans-serif;
    background:var(--off-white);
    padding:40px 20px;
    display:flex;
    justify-content:center;
}

.dashboard{
    width:100%;
    max-width:850px;
}

.header-actions{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
    flex-wrap:wrap;
    gap:20px;
}

.header-actions h2{
    font-family:'Sora';
    font-size:30px;
    color:var(--navy-deep);
}

.welcome{
    margin-top:5px;
    color:var(--text-muted);
}

.welcome span{
    color:var(--teal-accent);
    font-weight:700;
}

.buttons{
    display:flex;
    gap:10px;
}

.btn-add{
    background:linear-gradient(135deg,var(--navy-mid),var(--teal-accent));
    color:white;
    text-decoration:none;
    padding:12px 18px;
    border-radius:10px;
    font-weight:700;
}

.btn-logout{
    background:#fff5f5;
    color:var(--error);
    text-decoration:none;
    padding:12px 18px;
    border-radius:10px;
    border:1px solid #f8d7da;
    font-weight:700;
}

.search-input{
    width:100%;
    padding:14px;
    border-radius:12px;
    border:1px solid var(--border);
    margin-bottom:25px;
    font-size:14px;
}

.tasks-list{
    display:flex;
    flex-direction:column;
    gap:16px;
}

.task-card{
    background:white;
    border:1px solid var(--border);
    border-radius:14px;
    padding:20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.task-title{
    font-family:'Sora';
    font-size:18px;
    margin-bottom:8px;
    color:var(--navy-deep);
}

.task-meta{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
    align-items:center;
}

.badge-cat{
    background:var(--input-bg);
    color:var(--navy-mid);
    padding:4px 10px;
    border-radius:20px;
    font-size:12px;
    font-weight:700;
}

.priority-high{
    color:red;
    font-weight:700;
}

.priority-medium{
    color:orange;
    font-weight:700;
}

.priority-low{
    color:green;
    font-weight:700;
}

.date{
    font-size:13px;
    color:var(--text-muted);
}

/* ACTION BUTTONS */

.task-actions{
    display:flex;
    gap:10px;
    align-items:center;
}

.btn-edit{
    background:#eef6ff;
    color:var(--teal-accent);
    border:1px solid #cfe8ff;
    padding:8px 14px;
    border-radius:8px;
    text-decoration:none;
    font-weight:700;
    transition:0.3s;
}

.btn-edit:hover{
    background:var(--teal-accent);
    color:white;
}

.btn-delete{
    background:#fff5f5;
    color:var(--error);
    border:1px solid #f8d7da;
    padding:8px 14px;
    border-radius:8px;
    cursor:pointer;
    font-weight:700;
    text-decoration:none;
    transition:0.3s;
}

.btn-delete:hover{
    background:var(--error);
    color:white;
}

.no-task{
    text-align:center;
    padding:30px;
    background:white;
    border-radius:12px;
    color:var(--text-muted);
    border:1px dashed var(--border);
}
/* TASK COMPLETED */
.task-card.completed{
    opacity:0.7;
    background:#fff0f0;
    border-color:#f5b5b5;
}

.task-card.completed .task-title{
    text-decoration: line-through;
    color:var(--error);
}
.task-card.completed .date{
    color: var(--error);
  }
.checkbox-complete{
    width:18px;
    height:18px;
    accent-color:var(--error);
    cursor:pointer;
}
</style>
</head>

<body>

<div class="dashboard">

    <div class="header-actions">

        <div>

            <h2>My Tasks</h2>

            <p class="welcome">
                Welcome
                <span>
                    <?= htmlspecialchars($userName) ?>
                </span>
                👋
            </p>

        </div>

        <div class="buttons">

            <a href="create_task.html" class="btn-add">
                + New Task
            </a>

            <a href="logout.php" class="btn-logout">
                Logout
            </a>

        </div>

    </div>

    <input
        type="text"
        id="searchInput"
        class="search-input"
        placeholder="🔍 Search tasks..."
        oninput="filtrerTaches()"
    >

    <?php if(count($tasks) > 0): ?>

    <div class="tasks-list" id="tasksContainer">

        <?php foreach($tasks as $task): ?>

       <div class="task-card <?= $task['is_done'] == 1 ? 'completed' : '' ?>">

    <input type="checkbox" class="checkbox-complete" onchange="toggleTask(this, <?= $task['id'] ?>)" <?= $task['is_done'] == 1 ? 'checked' : '' ?>>

            <div style="display:flex; gap:4px; align-items:flex-start;">  
                <h3 class="task-title">
                    <?= htmlspecialchars($task['titre']) ?>
                </h3>

                <div class="task-meta">

<span class="badge-cat">

<?php
    switch($task['categorie_id']){

        case 1:
            echo '📝 Work';
            break;

        case 2:
            echo '🏠 Personal';
            break;

        case 3:
            echo '🎯 Goals';
            break;

        case 4:
            echo '🛒 Shopping';
            break;

        default:
            echo '📁 Unknown';
    }
?>

</span>

                    <span class="date">
                        📅 <?= htmlspecialchars($task['date_limite']) ?>
                    </span>

<span class="
<?php
    if($task['priorite'] == 'Haute'){
        echo 'priority-high';
    }
    elseif($task['priorite'] == 'Moyenne'){
        echo 'priority-medium';
    }
    else{
        echo 'priority-low';
    }
?>
">

<?php
    if($task['priorite'] == 'Haute'){
        echo '🔴';
    }
    elseif($task['priorite'] == 'Moyenne'){
        echo '🟡';
    }
    else{
        echo '🟢';
    }
?>

</span>

                </div>

            </div>

            <!-- ACTION BUTTONS -->

            <div class="task-actions">

                <a 
                    href="edit_task.php?id=<?= $task['id'] ?>" 
                    class="btn-edit"
                >
                    Edit
                </a>

                <a 
                    href="delete_task.php?id=<?= $task['id'] ?>" 
                    class="btn-delete"
                >
                    Delete
                </a>

            </div>

        </div>

        <?php endforeach; ?>

    </div>

    <?php else: ?>

    <div class="no-task">
        No tasks found.
    </div>

    <?php endif; ?>

</div>

<script>

function filtrerTaches(){

    const query = document
        .getElementById('searchInput')
        .value
        .toLowerCase();

    const cards = document.querySelectorAll('.task-card');

    cards.forEach(card => {

        const title = card
            .querySelector('.task-title')
            .innerText
            .toLowerCase();

        if(title.includes(query)){
            card.style.display = 'flex';
        }
        else{
            card.style.display = 'none';
        }

    });

}
function toggleTask(checkbox){

    const card = checkbox.closest('.task-card');

    if(checkbox.checked){
        card.classList.add('completed');
    } else {
        card.classList.remove('completed');
    }

}
</script>
<script>
function toggleTask(checkbox, taskId){

    const isDone = checkbox.checked ? 1 : 0;

    const card = checkbox.closest('.task-card');

    // effet visuel
    if(isDone){
        card.classList.add('completed');
    } else {
        card.classList.remove('completed');
    }

    // envoi vers PHP
    fetch('update_task_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${taskId}&is_done=${isDone}`
    });
}
</script>
</body>
</html>