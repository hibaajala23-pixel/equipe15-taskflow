INSERT INTO users
(name,email,password)
VALUES
('Hayat', 'hayat@gmail.com', '123456'),

('Sara','sara@gmail.com', '123456');


ALTER TABLE tasks ADD is_done TINYINT(1) DEFAULT 0;

INSERT INTO categories (id, nom_categorie) VALUES
(1, 'Work'),
(2, 'Personal'),
(3, 'Goals'),
(4, 'Shopping');



INSERT INTO tasks
(titre, description, statut, priorite, date_limite, user_id, categorie_id)
VALUES
(
'Créer interface',
'Développement frontend TaskFlow',
'A faire',
'Haute',
'2026-06-01',
1,
1
),

(
'Préparer rapport',
'Rédaction livrable final',
'En cours',
'Moyenne',
'2026-06-05',
2,
2
);



INSERT INTO notifications
(message, date_notification, user_id, task_id)
VALUES
(
'La tâche arrive à échéance',
'2026-05-20 10:00:00',
1,
1
);



INSERT INTO comments
(contenu, user_id, task_id)
VALUES
(
'Cette tâche doit être terminée rapidement',
1,
1
);



INSERT INTO tags
(nom_tag)
VALUES
('Urgent'),
('Backend'),
('Frontend');



INSERT INTO task_tags
(task_id, tag_id)
VALUES
(1,1),
(1,3),
(2,2);