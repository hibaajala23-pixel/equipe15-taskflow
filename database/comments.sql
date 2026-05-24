CREATE TABLE comments (

    id INT PRIMARY KEY AUTO_INCREMENT,

    contenu TEXT NOT NULL,

    created_at TIMESTAMP
    DEFAULT CURRENT_TIMESTAMP,

    user_id INT,

    task_id INT,

    FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON DELETE CASCADE,

    FOREIGN KEY (task_id)
    REFERENCES tasks(id)
    ON DELETE CASCADE
);