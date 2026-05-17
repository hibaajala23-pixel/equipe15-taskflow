CREATE TABLE notifications (

    id INT PRIMARY KEY AUTO_INCREMENT,

    message TEXT NOT NULL,

    date_notification DATETIME,

    lu BOOLEAN DEFAULT FALSE,

    user_id INT,

    task_id INT,

    FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON DELETE CASCADE,

    FOREIGN KEY (task_id)
    REFERENCES tasks(id)
    ON DELETE CASCADE
);