-- ─── Créer la base de données ────────────────────────────────────────────────
CREATE DATABASE IF NOT EXISTS taskflow
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE taskflow;

-- ─── Table des utilisateurs ───────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS users (
    id         INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    full_name  VARCHAR(100)    NOT NULL,
    email      VARCHAR(180)    NOT NULL,
    password   VARCHAR(255)    NOT NULL,       -- bcrypt hash
    created_at TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
