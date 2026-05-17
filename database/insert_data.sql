INSERT INTO users
(nom, prenom, email, mot_de_passe, role)
VALUES
('Hayat', 'Zak', 'hayat@gmail.com', '123456', 'admin'),

('Sara', 'Ali', 'sara@gmail.com', '123456', 'user');



INSERT INTO categories
(nom_categorie)
VALUES
('Travail'),
('Etudes'),
('Personnel');



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