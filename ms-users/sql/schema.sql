DROP TABLE IF EXISTS `users`;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (name,email) VALUES ('Liam','liam@gmail.com');
INSERT INTO users (name,email) VALUES ('Olivia','olivia@gmail.com');
INSERT INTO users (name,email) VALUES ('George','george@gmail.com');
INSERT INTO users (name,email) VALUES ('Thomas','thomas@gmail.com');
INSERT INTO users (name,email) VALUES ('Alfred','alfred@gmail.com');
