# TaskFlow

TaskFlow est une application web de gestion de tâches développée en PHP, MySQL, HTML, CSS et JavaScript.

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

```bash
git clone https://github.com/VOTRE-USERNAME/taskflow.git
```

### 2. Importer la base de données

Importer le fichier :

```sql
database.sql
```

dans phpMyAdmin.

### 3. Installer les dépendances

```bash
composer install
```

### 4. Configurer la base de données

Modifier le fichier :

```php
db.php
```

et renseigner :

```php
$host = "localhost";
$dbname = "taskflow";
$username = "root";
$password = "";
```

### 5. Configurer PHPMailer

Dans le fichier :

```php
send_reminders.php
```

renseigner :

```php
$mail->Username = "votre_email@gmail.com";
$mail->Password = "votre_app_password";
```

### 6. Lancer le projet

Placer le projet dans :

```text
htdocs/
```

puis ouvrir :

```text
http://localhost/taskflow
```

## Structure du projet

```text
taskflow/
│
├── dashboard.php
├── create_task.php
├── save_task.php
├── edit_task.php
├── delete_task.php
├── login.php
├── register.php
├── logout.php
├── send_reminders.php
├── db.php
├── composer.json
├── composer.lock
└── README.md

 Auteur

Développé par [CHROROU HIBA , HIBA AJALA , HAYAT ZAK]

