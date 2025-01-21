CREATE DATABASE Youdemy;
USE Youdemy;

CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(250) NOT NULL,
    prenom VARCHAR(250) NOT NULL,
    email VARCHAR(250) UNIQUE NOT NULL,
    password VARCHAR(250) NOT NULL,
    role ENUM('Etudiant', 'Enseignant', 'Administrateur') NOT NULL,
    compte_statut ENUM('Actif', 'Non Actif', 'Suspendu', 'Supprimé') DEFAULT 'Non Actif' NOT NULL
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
    description TEXT,
    contenu VARCHAR(250),
    categorie_id INT NOT NULL,
    user_id INT,
    FOREIGN KEY (categorie_id) REFERENCES Categorie(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE CoursTag (
    cours_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (cours_id, tag_id),
    FOREIGN KEY (cours_id) REFERENCES Cours(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES Tag(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE DateInscription (
    id INT AUTO_INCREMENT PRIMARY KEY,
    etudiant_id INT NOT NULL,
    cours_id INT NOT NULL,
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (etudiant_id) REFERENCES Users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (cours_id) REFERENCES Cours(id) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO Users (nom, prenom, email, password, role, compte_statut)
VALUES 
('Mohammed', 'Ayoub', 'said@gmail.com', 'ss', 'Etudiant', 'Non Actif'),
('Youness', 'Sofia', 'aziz@gmail.com', 'zz', 'Enseignant', 'Non Actif'),
('Aziz', 'Ali', 'ayoub@gmail.com', 'vv', 'Etudiant', 'Non Actif'),
('Ayoub', 'Labit', 'ayoub.labite@gmail.com', 'bb', 'Administrateur', 'Actif'),
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

INSERT INTO Cours (titre, description, contenu, categorie_id, user_id)
VALUES 
('Apprendre PHP pour Débutants', 'Un cours complet pour apprendre PHP.', 'https://www.youtube.com/embed/php-course', 1, 2),
('Introduction à JavaScript', 'Apprenez les bases de JavaScript.', 'https://www.youtube.com/embed/javascript-course', 1, 2),
('Analyse des Données avec Python', 'Explorez les bases de la science des données.', 'https://www.youtube.com/embed/python-data-analysis', 2, 2),
('Design UX/UI', 'Un guide pour concevoir des interfaces utilisateur.', 'https://www.youtube.com/embed/design-ux-ui', 3, 2);

INSERT INTO CoursTag (cours_id, tag_id)
VALUES 
(1, 1),
(2, 2),
(3, 5),
(4, 4);

INSERT INTO DateInscription (etudiant_id, cours_id, date_inscription)
VALUES 
(1, 1, '2025-01-10 10:00:00'),
(3, 2, '2025-01-11 15:00:00'),
(1, 3, '2025-01-12 08:00:00');
