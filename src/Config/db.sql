CREATE DATABASE Youdemy;
USE Youdemy;

CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(250),
    prenom VARCHAR(250),
    email VARCHAR(250),
    `password` VARCHAR(250),
    `role` ENUM('Etudiant', 'Enseignant', 'Administrateur'),
    compte_statut ENUM('Actif', 'Non Actif', 'Suspensse', 'Supprimer')
);

CREATE TABLE Categorie (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    nom VARCHAR(250)
);

CREATE TABLE Tag (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50)
);


CREATE TABLE Cours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(250),
    `description` TEXT,
    contenu VARCHAR(250),
    categorie_id INT,
    tag_id INT,
    FOREIGN KEY (tag_id) REFERENCES Tag(id),
    FOREIGN KEY (categorie_id) REFERENCES Categorie(id)
);

CREATE TABLE CoursTag (
    Cours_id INT,
    tag_id INT,
    FOREIGN KEY (Cours_id) REFERENCES Cours(id),
    FOREIGN KEY (tag_id) REFERENCES Tag(id)
);

CREATE TABLE DateInscription (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Etudiant_id INT,
    Cours_id INT,
    date_Inscription DATETIME,
    FOREIGN KEY (Etudiant_id) REFERENCES Users(id),
    FOREIGN KEY (Cours_id) REFERENCES Cours(id)
);

INSERT INTO Users (nom, prenom, email, password, role, compte_statut)
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

INSERT INTO Cours (titre, description, contenu, categorie_id, tag_id)
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