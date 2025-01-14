CREATE DATABASE Youdemy;
USE Youdemy;

CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(250) NOT NULL,
    prenom VARCHAR(250) NOT NULL,
    email VARCHAR(250) UNIQUE NOT NULL,
    `password` VARCHAR(250) NOT NULL,
    `role` ENUM('Etudiant', 'Enseignant', 'Administrateur') NOT NULL,
    compte_statut ENUM('Actif', 'Non Actif', 'Suspensse', 'Supprimer') DEFAULT 'Non Actif' NOT NULL
);

CREATE TABLE Categorie (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(250) NOT NULL
);

CREATE TABLE Tag (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE Cours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(250) NOT NULL,
    `description` TEXT,
    contenu VARCHAR(250),
    categorie_id INT NOT NULL,
    tag_id INT,
    FOREIGN KEY (categorie_id) REFERENCES Categorie(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES Tag(id) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE CoursTag (
    Cours_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (Cours_id, tag_id),
    FOREIGN KEY (Cours_id) REFERENCES Cours(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES Tag(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE DateInscription (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Etudiant_id INT NOT NULL,
    Cours_id INT NOT NULL,
    date_Inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (Etudiant_id) REFERENCES Users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (Cours_id) REFERENCES Cours(id) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO Users (nom, prenom, email, `password`, `role`, compte_statut)
VALUES 
('Mohammed', 'Ayoub', 'mohammed@gmail.com', 'hfffffff', 'Etudiant', 'Non Actif'),
('Youness', 'Sofia', 'youness@gmail.com', 'dddddddddddd', 'Enseignant', 'Non Actif'),
('Aziz', 'Ali', 'aziz@gmail.com', 'llllllll', 'Etudiant', 'Non Actif'),
('Ayoub', 'Labit', 'ayoub.labite@hotmail.com', 'bb', 'Administrateur', 'Actif'),
('Keltoum', 'Keltoum', 'keltoum@hotmail.com', '1234', 'Enseignant', 'Non Actif');

INSERT INTO Categorie (nom)
VALUES 
('Développement Web'),
('Data Science'),
('Design Graphique'),
('Marketing Digital');

INSERT INTO Tag (nom)
VALUES 
('PHP'),
('JavaScript'),
('HTML'),
('CSS'),
('Python'),
('SQL');

INSERT INTO Cours (titre, `description`, contenu, categorie_id, tag_id)
VALUES 
('Apprendre PHP pour Débutants', 'Un cours complet pour apprendre PHP.', 'https://www.youtube.com/watch?v=php-course', 1, 1),
('Introduction à JavaScript', 'Apprenez les bases de JavaScript.', 'https://www.youtube.com/watch?v=javascript-course', 1, 2),
('Analyse des Données avec Python', 'Explorez les bases de la science des données.', 'https://www.youtube.com/watch?v=python-data-analysis', 2, 5),
('Design UX/UI', 'Un guide pour concevoir des interfaces utilisateur.', 'https://www.youtube.com/watch?v=design-ux-ui', 3, 4);

INSERT INTO CoursTag (Cours_id, tag_id)
VALUES 
(1, 1),
(2, 2),
(3, 5),
(4, 4);

INSERT INTO DateInscription (Etudiant_id, Cours_id, date_Inscription)
VALUES 
(1, 1, '2025-01-10 10:00:00'),
(3, 2, '2025-01-11 15:00:00'),
(1, 3, '2025-01-12 08:00:00');
