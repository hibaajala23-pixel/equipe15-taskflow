CREATE TABLE task_tags (

    task_id INT,

    tag_id INT,

    PRIMARY KEY(task_id, tag_id),

    FOREIGN KEY (task_id)
    REFERENCES tasks(id)
    ON DELETE CASCADE,

    FOREIGN KEY (tag_id)
    REFERENCES tags(id)
    ON DELETE CASCADE
);