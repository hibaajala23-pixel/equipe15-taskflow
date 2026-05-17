# TaskFlow — Backend PHP

## Structure du projet

```
taskflow/
├── index.php                  ← Page principale (login / register)
├── config/
│   ├── database.php           ← Connexion PDO MySQL
│   └── schema.sql             ← Script de création de la base de données
├── includes/
│   └── session.php            ← Gestion sessions, CSRF, helpers auth
├── auth/
│   ├── login.php              ← Handler POST connexion
│   ├── register.php           ← Handler POST inscription
│   └── logout.php             ← Déconnexion
└── dashboard/
    └── index.php              ← Page protégée après connexion
```

---

## Installation locale (XAMPP / WAMP / Laragon)

### 1. Copier le projet

Placez le dossier `taskflow/` dans :
- **XAMPP** → `C:/xampp/htdocs/taskflow/`
- **Laragon** → `C:/laragon/www/taskflow/`

### 2. Créer la base de données

Ouvrez **phpMyAdmin** → onglet SQL → collez et exécutez le contenu de `config/schema.sql`.

Ou via terminal :
```bash
mysql -u root -p < config/schema.sql
```

### 3. Configurer la connexion

Ouvrez `config/database.php` et adaptez :
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'taskflow');
define('DB_USER', 'root');   // votre utilisateur MySQL
define('DB_PASS', '');       // votre mot de passe MySQL
```

### 4. Lancer

Ouvrez votre navigateur :
```
http://localhost/taskflow/
```

---

## Fonctionnalités incluses

| Fonctionnalité       | Détail                                           |
|----------------------|--------------------------------------------------|
| Inscription          | Validation serveur + hachage bcrypt (cost 12)   |
| Connexion            | Vérification `password_verify()` (timing-safe)  |
| Sessions sécurisées  | `httponly`, `samesite=Strict`, régénération ID  |
| Protection CSRF      | Token aléatoire 64 caractères (hex), vérification `hash_equals` |
| Redirection          | Vers `/taskflow/dashboard/` après auth           |
| Dashboard protégé    | `requireLogin()` bloque les accès non authentifiés |
| Déconnexion          | Destruction complète de la session               |

---

## Notes de sécurité

- En **production** : activez `'secure' => true` dans `session.php` (HTTPS obligatoire).
- Ne jamais committer `config/database.php` avec de vraies credentials → ajoutez-le au `.gitignore`.

## .gitignore recommandé

```
config/database.php
*.log
.DS_Store
```
