-- ========================================================
-- PROJET : Taskflow - Système de Gestion des Tâches
-- CONCEPTION : Hayat Zak (Product Owner / Database)
-- FILE : optimization.sql (Sprint 2 - Optimisation & Dashboard)
-- ========================================================

USE taskflow_db;

-- 1. Ajout d'index pour accélérer le filtrage et la recherche (US-04, US-05, US-06)
-- Ces index permettent d'accélérer les requêtes SELECT complexes sur l'état, la priorité et les dates d'échéances.
CREATE INDEX idx_tasks_status ON tasks(status);
CREATE INDEX idx_tasks_priority ON tasks(priority);
CREATE INDEX idx_tasks_due_date ON tasks(due_date);

-- 2. Création d'une Vue pour le Tableau de Bord (US-10)
-- Cette vue permet au Backend d'analyser les statistiques par utilisateur en un seul coup sans faire de requêtes lentes.
CREATE OR REPLACE VIEW v_user_task_statistics AS
SELECT 
    u.id AS user_id,
    u.username,
    COUNT(t.id) AS total_tasks,
    SUM(CASE WHEN t.status = 'PENDING' THEN 1 ELSE 0 END) AS pending_tasks,
    SUM(CASE WHEN t.status = 'COMPLETED' THEN 1 ELSE 0 END) AS completed_tasks,
    ROUND((SUM(CASE WHEN t.status = 'COMPLETED' THEN 1 ELSE 0 END) / COUNT(t.id)) * 100, 2) AS completion_rate
FROM users u
LEFT JOIN tasks t ON u.id = t.user_id
GROUP BY u.id, u.username;

-- 3. Insertion de données de test supplémentaires pour valider les filtres et le tri (Sprint 2)
INSERT INTO tasks (user_id, category_id, title, description, priority, status, due_date) VALUES 
(1, 1, 'Préparer le rapport final PDF', 'Rapport de 4 à 8 pages pour Pr. Sanae', 'HIGH', 'PENDING', NOW() + INTERVAL 2 DAY),
(1, 2, 'Acheter des provisions', 'Courses pour la semaine', 'LOW', 'COMPLETED', NOW() - INTERVAL 1 DAY),
(1, 3, 'Réviser la soutenance', 'Préparation des slides PowerPoint', 'HIGH', 'PENDING', NOW() + INTERVAL 5 DAY)
ON DUPLICATE KEY UPDATE title=title;
```
eof

### Chnou ghadir dba dqa b dqa?

1. **Copier** had s-code complet.
2. **Collih** f l-fichié `src/database/sprint2/optimization.sql` li t-7l lik f VS Code.
3. Diri **Ctrl + S** bash t-sajlih.
4. Rj3i l l-terminal **Git Bash** w pussi l-khdma b had s-stora kima l-3ada:
   ```bash
   git add src/database/sprint2/optimization.sql
   git commit -m "feat(database): ajouter index et vue statistique pour le sprint 2"
   git push origin sprint-2