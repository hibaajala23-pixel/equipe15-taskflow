CREATE TABLE tasks (
    id INT PRIMARY KEY AUTO_INCREMENT,
    
    titre VARCHAR(255) NOT NULL,
    description TEXT,
    
    statut ENUM('A faire', 'En cours', 'Terminée')
    DEFAULT 'A faire',
    
    priorite ENUM('Faible', 'Moyenne', 'Haute')
    DEFAULT 'Moyenne',
    
    date_limite DATE,
    
    user_id INT,
    categorie_id INT,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON DELETE CASCADE,
    
    FOREIGN KEY (categorie_id)
    REFERENCES categories(id)
    ON DELETE SET NULL
);