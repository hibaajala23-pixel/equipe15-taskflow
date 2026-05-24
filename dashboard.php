<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TaskFlow — Dashboard</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet" />
  <style>
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
      padding: 40px 20px;
      display: flex;
      justify-content: center;
    }

    .dashboard {
      width: 100%;
      max-width: 800px;
    }

    .header-actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 24px;
    }

    .header-actions h2 {
      font-family: 'Sora', sans-serif;
      font-size: 28px;
      font-weight: 800;
      color: var(--navy-deep);
    }

    .btn-add {
      background: linear-gradient(135deg, var(--navy-mid) 0%, var(--teal-accent) 100%);
      color: var(--white);
      padding: 12px 20px;
      border-radius: 10px;
      text-decoration: none;
      font-family: 'Sora', sans-serif;
      font-size: 14px;
      font-weight: 700;
      box-shadow: 0 4px 12px rgba(14,52,96,.2);
    }

    /* Search Utility Layout */
    .search-wrapper {
      margin-bottom: 32px;
    }
    .search-input {
      width: 100%;
      padding: 14px 16px;
      background: var(--white);
      border: 1.5px solid var(--border);
      border-radius: 12px;
      font-family: 'DM Sans', sans-serif;
      font-size: 14.5px;
      color: var(--text-dark);
      outline: none;
      transition: all 0.2s;
    }
    .search-input:focus {
      border-color: var(--teal-accent);
      box-shadow: 0 0 0 3px rgba(26,127,190,.12);
    }

    /* Errors Handling & Fallbacks States */
    .no-tasks {
      display: none;
      text-align: center;
      padding: 40px;
      background: var(--white);
      border-radius: 12px;
      border: 1.5px dashed var(--border);
      color: var(--text-muted);
      font-size: 15px;
      font-family: 'Sora', sans-serif;
    }

    .tasks-list {
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .task-card {
      background: var(--white);
      border: 1.5px solid var(--border);
      border-radius: 14px;
      padding: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      transition: all 0.3s ease;
    }

    .task-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(10, 30, 53, 0.04);
    }

    /* Completed Strikethrough Engine Style Rules */
    .task-card.completed {
      opacity: 0.55;
      background-color: #fcfdfe;
    }
    .task-card.completed h3 {
      text-decoration: line-through;
      color: var(--text-muted);
    }
    .task-card.completed .badge {
      background: #e2e8ef !important;
      color: var(--text-muted) !important;
    }

    .task-left-section {
      display: flex;
      align-items: center;
      gap: 18px;
    }

    .task-checkbox {
      width: 22px;
      height: 22px;
      border-radius: 6px;
      border: 2px solid var(--text-muted);
      accent-color: var(--teal-accent);
      cursor: pointer;
    }

    .task-info h3 {
      font-family: 'Sora', sans-serif;
      font-size: 18px;
      font-weight: 700;
      color: var(--navy-deep);
      margin-bottom: 8px;
    }

    .task-meta {
      display: flex;
      gap: 10px;
      align-items: center;
    }

    .badge {
      font-size: 11px;
      font-weight: 700;
      padding: 4px 10px;
      border-radius: 20px;
      text-transform: uppercase;
    }

    .badge-cat { background: var(--input-bg); color: var(--navy-mid); }
    
    .priority-high { background: #fff5f5; color: var(--error); }
    .priority-medium { background: #fffbeb; color: #d97706; }
    .priority-low { background: #f0fdf4; color: #16a34a; }

    .due-date {
      font-size: 12px;
      color: var(--text-muted);
    }

    .reminder-tag {
      font-size: 11px;
      color: var(--teal-accent);
      font-weight: 600;
    }

    .task-buttons {
      display: flex;
      gap: 10px;
    }

    .btn-edit {
      background: var(--input-bg);
      color: var(--navy-mid);
      border: none;
      padding: 8px 14px;
      border-radius: 8px;
      text-decoration: none;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
    }

    .btn-delete {
      background: #fff5f5;
      color: var(--error);
      border: 1.5px solid #f8d7da;
      padding: 8px 14px;
      border-radius: 8px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s;
    }

    .btn-delete:hover {
      background: var(--error);
      color: var(--white);
      border-color: var(--error);
    }
  </style>
</head>
<body>

<div class="dashboard">
  
  <div class="header-actions">
    <h2>My Tasks</h2>
    <a href="create_task.html" class="btn-add">+ New Task</a>
  </div>

  <!-- Realtime Input Field Filter Component -->
  <div class="search-wrapper">
    <input type="text" id="searchInput" class="search-input" placeholder="🔍 Search tasks by title or category..." oninput="filtrerTaches()" />
  </div>

  <!-- Conditional Fallback Warning Text Box -->
  <div class="no-tasks" id="noTasksMessage">
    Aucune tâche correspondante trouvée.
  </div>

  <!-- Workspace Shell Container -->
  <div class="tasks-list" id="tasksContainer">
    
    <!-- Task Row Example Item 1 -->
    <div class="task-card" id="task-1" data-reminder="2026-05-20T14:30">
      <div class="task-left-section">
        <input type="checkbox" class="task-checkbox" onchange="toggleTaskComplete('task-1', this)" />
        <div class="task-info">
          <h3 class="task-title">Finalize presentation slides</h3>
          <div class="task-meta">
            <span class="badge badge-cat">Work</span>
            <span class="badge priority-high">🔴 High</span>
            <span class="due-date">📅 May 20, 2026</span>
            <span class="reminder-tag">⏰ Alert active</span>
          </div>
        </div>
      </div>
      <div class="task-buttons">
        <a href="edit_task.html" class="btn-edit">Edit</a>
        <button class="btn-delete" onclick="confirmerSuppression('task-1')">Delete</button>
      </div>
    </div>

    <!-- Task Row Example Item 2 -->
    <div class="task-card" id="task-2">
      <div class="task-left-section">
        <input type="checkbox" class="task-checkbox" onchange="toggleTaskComplete('task-2', this)" />
        <div class="task-info">
          <h3 class="task-title">Buy cat food and dynamic litter setup</h3>
          <div class="task-meta">
            <span class="badge badge-cat">Personal</span>
            <span class="badge priority-medium">🟡 Medium</span>
            <span class="due-date">📅 May 25, 2026</span>
          </div>
        </div>
      </div>
      <div class="task-buttons">
        <a href="edit_task.html" class="btn-edit">Edit</a>
        <button class="btn-delete" onclick="confirmerSuppression('task-2')">Delete</button>
      </div>
    </div>

  </div>
</div>

<script>
  // --- NOTIFICATION API INITIALIZER ---
  document.addEventListener('DOMContentLoaded', () => {
    if ("Notification" in window) {
      if (Notification.permission !== "granted" && Notification.permission !== "denied") {
        Notification.requestPermission();
      }
    }
  });

  // --- RUNTIME LIVE QUERY TERM SEARCH COMPONENT ---
  function filtrerTaches() {
    const query = document.getElementById('searchInput').value.toLowerCase().trim();
    const cards = document.querySelectorAll('.task-card');
    const errorMessage = document.getElementById('noTasksMessage');
    let visibleCardsCount = 0;

    cards.forEach(card => {
      const title = card.querySelector('.task-title').innerText.toLowerCase();
      const category = card.querySelector('.badge-cat').innerText.toLowerCase();

      if (title.includes(query) || category.includes(query)) {
        card.style.display = 'flex';
        visibleCardsCount++;
      } else {
        card.style.display = 'none';
      }
    });

    errorMessage.style.display = visibleCardsCount === 0 ? 'block' : 'none';
  }

  // --- STATUS CHANGE TOGGLER STYLES ---
  function toggleTaskComplete(taskCardId, checkbox) {
    const taskCard = document.getElementById(taskCardId);
    if (checkbox.checked) {
      taskCard.classList.add('completed');
    } else {
      taskCard.classList.remove('completed');
    }
  }

  // --- CONFIRMATION DIALOG MODAL ON FRONTIERS ACTION ---
  function confirmerSuppression(taskCardId) {
    const confirmation = confirm("Êtes-vous sûr de vouloir supprimer définitivement cette tâche ?");
    if (confirmation) {
      const taskCard = document.getElementById(taskCardId);
      if (taskCard) {
        taskCard.remove();
        filtrerTaches(); 
      }
    }
  }

  // --- BACKGROUND TIME-CHECK CLOCK WATCHER ---
  function verifierRappels() {
    const maintenant = new Date();
    const maintenantFormate = maintenant.getFullYear() + '-' +
      String(maintenant.getMonth() + 1).padStart(2, '0') + '-' +
      String(maintenant.getDate()).padStart(2, '0') + 'T' +
      String(maintenant.getHours()).padStart(2, '0') + ':' +
      String(maintenant.getMinutes()).padStart(2, '0');

    const taches = document.querySelectorAll('.task-card[data-reminder]');

    taches.forEach(tache => {
      const heureRappel = tache.getAttribute('data-reminder');
      const dejaNotifie = tache.getAttribute('data-notified');

      if (heureRappel === maintenantFormate && dejaNotifie !== "true") {
        const titreTache = tache.querySelector('.task-title').innerText;

        if (Notification.permission === "granted") {
          new Notification("TaskFlow Reminder! ⏰", {
            body: `Don't forget: "${titreTache}" needs your attention right now.`,
            icon: "https://cdn-icons-png.flaticon.com/512/3114/3114810.png"
          });
        } else {
          alert(`⏰ REMINDER: ${titreTache}`);
        }
        tache.setAttribute('data-notified', "true");
      }
    });
  }

  // Poll system times continuously
  setInterval(verifierRappels, 1000);
</script>
</body>
</html>