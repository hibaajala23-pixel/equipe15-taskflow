# TaskFlow

TaskFlow est une application web de gestion de tâches développée en PHP, MySQL, HTML, CSS et JavaScript.
Cette application a pour objectif organiser les taches que ce soient personnelle, professionnelle etc.. 

# Membre de l'equipe
HIBA AJALA : developpeur
CHROROU HIBA : Scrum Master
HAYAT ZAK : Product owner
## Fonctionnalités

* Inscription et connexion utilisateur
* Authentification sécurisée avec mot de passe hashé
* Création de tâches
* Modification de tâches
* Suppression de tâches
* Recherche de tâches
* Filtrage par catégorie
* Filtrage par priorité
* Marquage des tâches comme terminées
* Gestion des catégories
* Rappels par email avec PHPMailer
* Interface responsive pour mobile et desktop

## Technologies utilisées

* PHP
* MySQL
* HTML5
* CSS3
* JavaScript
* PHPMailer
* Composer

## Installation

### 1. Cloner le projet

git clone https://github.com/hibaajala23-pixel/equipe15-taskflow.git

### 2. Importer la base de données

Importer le fichier :

database.sql

dans phpMyAdmin.

### 3. Installer les dépendances

composer install

### 4. Configurer la base de données

Modifier le fichier :

db.php

et renseigner :

$host = "sql111.infinityfree.com";
$dbname = "if0_42051541_taskflow";
$username = "if0_42051541";
$password = "mFMpCUNmhO4";

### 5. Configurer PHPMailer

Dans le fichier :

send_reminders.php

renseigner :

$mail->Username = "h.chrorou@gmail.com";
$mail->Password = "nphx bouz qryd hakj";

### 6. Lancer le projet

Placer le projet dans :

htdocs/

puis ouvrir :

http://localhost/taskflow

## Live Demo

https://taskflow-app.infinityfree.me

# compte de test 
 email : "test2026@gmail.com"
 password :"12341

## Structure du projet

taskflow/
├──  README.md
├── .gitignore
├── docs/
    ├──Cahier de charge.pdf
    ├── WBS-Gantt & Backlog.pdf
├── src/
    ├── frontend/
        ├── index.html
        ├── connexion.html
        ├── signup.php
        ├── forgot_password.php
        ├── create_task.php
        ├── dashboard.php
        ├── edit_task.php
    ├── backend/
        ├── login.php
        ├── db.php
        ├── save_task.php
        ├── register.php
        ├── delete_task.php
        ├── send_reminders.php
        ├── toggle_task.php
        ├── edit_task.php
        ├── logout.php
        ├──reset_password.php
    ├──database/
        ├── categories.sql
        ├── comments.sql
        ├── insert_data.sql
        ├── notifications.sql
        ├── schema.sql
        ├── tags.sql
        ├── task_tags.sql
        ├── tasks.sql
        ├── users.sql


Développé par :

HIBA AJALA 
HAYAT ZAK
CHROROU HIBA 
 

