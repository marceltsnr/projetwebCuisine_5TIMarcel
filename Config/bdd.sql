CREATE TABLE utilisateur (
  id INT NOT NULL AUTO_INCREMENT,
  nomUser VARCHAR(255) NOT NULL,
  prenomUser VARCHAR(25) NOT NULL,
  loginUser VARCHAR(25) NOT NULL,
  passWordUser VARCHAR(25) NOT NULL,
  role VARCHAR(255) DEFAULT 'user',
  emailUser VARCHAR(40),
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO utilisateur (nomUser, prenomUser, loginUser, passWordUser, role, emailUser) VALUES
('CELOUMAR', 'ADMIN', 'celoumar', 'celoumar', 'admin', 'celoumar@gmail.com'),
('MARCELOU', 'USER', 'marcelou', 'marcelou', 'user', 'marcelou@gmail.com'),
('Dupont', 'Alice', 'alice', 'alice123', 'user', 'alice@gmail.com'),
('Martin', 'Lucas', 'lucas', 'lucas123', 'user', 'lucas@gmail.com'),
('Durand', 'Emma', 'emma', 'emma123', 'user', 'emma@gmail.com'),
('Petit', 'Noah', 'noah', 'noah123', 'user', 'noah@gmail.com'),
('Robert', 'Lina', 'lina', 'lina123', 'user', 'lina@gmail.com'),
('Moreau', 'Tom', 'tom', 'tom123', 'user', 'tom@gmail.com'),
('Fournier', 'Sarah', 'sarah', 'sarah123', 'user', 'sarah@gmail.com'),
('Girard', 'Leo', 'leo', 'leo123', 'user', 'leo@gmail.com'),
('Andre', 'Julie', 'julie', 'julie123', 'user', 'julie@gmail.com'),
('Mercier', 'Max', 'max', 'max123', 'user', 'max@gmail.com'),
('Blanc', 'Nina', 'nina', 'nina123', 'user', 'nina@gmail.com'),
('Faure', 'Paul', 'paul', 'paul123', 'user', 'paul@gmail.com'),
('Roux', 'Eva', 'eva', 'eva123', 'user', 'eva@gmail.com'),
('Vincent', 'Hugo', 'hugo', 'hugo123', 'user', 'hugo@gmail.com'),
('Henry', 'Clara', 'clara', 'clara123', 'user', 'clara@gmail.com'),
('Boyer', 'Ethan', 'ethan', 'ethan123', 'user', 'ethan@gmail.com'),
('Garnier', 'Lola', 'lola', 'lola123', 'user', 'lola@gmail.com'),
('Lefevre', 'Nathan', 'nathan', 'nathan123', 'user', 'nathan@gmail.com'),
('Perez', 'Chloe', 'chloe', 'chloe123', 'user', 'chloe@gmail.com');
CREATE TABLE categorie (
  categorieId INT NOT NULL AUTO_INCREMENT,
  nom VARCHAR(255) NOT NULL,
  PRIMARY KEY (categorieId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
INSERT INTO categorie (nom) VALUES
('Entrée'), ('Plat principal'), ('Dessert'), ('Apéritif'), ('Boisson'), ('Sauce'), ('Accompagnement'), ('Petit-déjeuner'), ('Brunch'), ('Snack'), ('Fast-food'), ('Cuisine du monde'), ('Vegan'), ('Bio'), ('Sans lactose'), ('Pâtisserie'), ('Barbecue'), ('Soupe'), ('Salade'), ('Repas de fête');

CREATE TABLE tag (
  tagId INT NOT NULL AUTO_INCREMENT,
  nom VARCHAR(255) NOT NULL,
  PRIMARY KEY (tagId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
INSERT INTO tag (nom) VALUES
('végétarien'), ('végétalien'), ('sans gluten'), ('rapide'), ('économique'), ('healthy'), ('comfort food'), ('épicé'), ('sucré'), ('salé'), ('saison'), ('été'), ('hiver'), ('printemps'), ('automne'), ('français'), ('italien'), ('asiatique'), ('mexicain'), ('oriental');
CREATE TABLE recette (
  recetteId INT NOT NULL AUTO_INCREMENT,
  recetteTitre VARCHAR(255) NOT NULL,
  recetteDescription TEXT,
  recetteIngredients TEXT NOT NULL,
  recetteEtapes TEXT NOT NULL,
  recetteTempsPreparation INT NOT NULL,
  recetteDifficulte VARCHAR(25) NOT NULL,
  recetteImage VARCHAR(255),
  utilisateurId INT
  categorieId INT,
  PRIMARY KEY (recetteId),
  FOREIGN KEY (utilisateurId) REFERENCES utilisateur(id),
  FOREIGN KEY (categorieId) REFERENCES categorie(categorieId)
);

-- ... (tables utilisateur, categorie, tag inchangées)

INSERT INTO recette 
(recetteTitre, recetteDescription, recetteIngredients, recetteImage, recetteEtapes, recetteTempsPreparation, recetteDifficulte, utilisateurId, categorieId)
VALUES
('Pâtes carbonara', 'Classique italien', 'Pâtes\nLardons\nŒufs\nCrème', 'https://img-3.journaldesfemmes.fr/URL_IMAGE.jpg', 'Cuire les pâtes\nMélanger\nServir', 25, 'facile', 2, 2),
('Gâteau chocolat', 'Moelleux', 'Chocolat\nBeurre\nŒufs\nSucre', 'https://img-3.journaldesfemmes.fr/URL_IMAGE.jpg', 'Mélanger\nCuire', 40, 'facile', 3, 3),
('Salade César', 'Fraîche', 'Salade\nPoulet\nParmesan', 'https://img-3.journaldesfemmes.fr/URL_IMAGE.jpg', 'Assembler', 20, 'facile', 4, 19),
('Quiche lorraine', 'Traditionnelle', 'Œufs\nCrème\nLardons', 'https://img-3.journaldesfemmes.fr/URL_IMAGE.jpg', 'Cuire au four', 50, 'moyen', 5, 2),
('Smoothie fruits', 'Vitaminé', 'Fruits\nYaourt', 'https://img-3.journaldesfemmes.fr/URL_IMAGE.jpg', 'Mixer', 10, 'facile', 6, 5),
('Burger maison', 'Gourmand', 'Pain\nSteak\nFromage', 'https://img-3.journaldesfemmes.fr/URL_IMAGE.jpg', 'Assembler', 25, 'facile', 7, 11),
('Soupe légumes', 'Réconfortante', 'Légumes\nBouillon', 'https://img-3.journaldesfemmes.fr/URL_IMAGE.jpg', 'Cuire\nMixer', 45, 'facile', 8, 18),
('Pizza maison', 'Personnalisée', 'Pâte\nTomate\nFromage', 'https://img-3.journaldesfemmes.fr/URL_IMAGE.jpg', 'Cuire', 60, 'moyen', 9, 2),
('Cookies', 'Gourmands', 'Farine\nChocolat', 'https://img-3.journaldesfemmes.fr/URL_IMAGE.jpg', 'Cuire', 30, 'facile', 10, 16),
('Omelette', 'Rapide', 'Œufs\nFromage', 'https://img-3.journaldesfemmes.fr/URL_IMAGE.jpg', 'Cuire', 10, 'facile', 11, 10),
('Risotto', 'Crémeux', 'Riz\nBouillon', 'https://img-3.journaldesfemmes.fr/URL_IMAGE.jpg', 'Remuer', 45, 'moyen', 12, 2),
('Crêpes', 'Sucrées', 'Farine\nLait\nŒufs', 'https://img-3.journaldesfemmes.fr/URL_IMAGE.jpg', 'Cuire', 30, 'facile', 13, 8),
('Curry légumes', 'Vegan', 'Légumes\nCurry', 'https://img-3.journaldesfemmes.fr/URL_IMAGE.jpg', 'Mijoter', 40, 'moyen', 14, 13),
('Salade fruits', 'Fraîche', 'Fruits', 'https://img-3.journaldesfemmes.fr/URL_IMAGE.jpg', 'Couper', 15, 'facile', 15, 3),
('Gratin dauphinois', 'Fondant', 'Pommes de terre\nCrème', 'https://img-3.journaldesfemmes.fr/URL_IMAGE.jpg', 'Cuire', 70, 'moyen', 16, 2),
('Wrap poulet', 'Lunch', 'Wrap\nPoulet', 'https://img-3.journaldesfemmes.fr/URL_IMAGE.jpg', 'Assembler', 15, 'facile', 17, 10),
('Muffins', 'Moelleux', 'Farine\nSucre', 'https://img-3.journaldesfemmes.fr/URL_IMAGE.jpg', 'Cuire', 35, 'facile', 18, 16),
('Chili con carne', 'Épicé', 'Bœuf\nHaricots', 'https://img-3.journaldesfemmes.fr/URL_IMAGE.jpg', 'Mijoter', 60, 'moyen', 19, 12),
('Tacos', 'Mexicain', 'Tortilla\nBœuf', 'https://img-3.journaldesfemmes.fr/URL_IMAGE.jpg', 'Assembler', 30, 'facile', 20, 11),
('Soupe miso', 'Asiatique', 'Miso\nTofu', 'https://img-3.journaldesfemmes.fr/URL_IMAGE.jpg', 'Chauffer', 20, 'facile', 2, 18);

CREATE TABLE tag_recette (
  tagRecetteId INT NOT NULL AUTO_INCREMENT,
  recetteId INT,
  tagId INT,
  PRIMARY KEY (tagRecetteId),
  FOREIGN KEY (recetteId) REFERENCES recette(recetteId),
  FOREIGN KEY (tagId) REFERENCES tag(tagId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO tag_recette (recetteId, tagId) VALUES
(1,17),
(2,9),
(3,6),
(4,16),
(5,4),
(6,7),
(7,13),
(8,7),
(9,9),
(10,4),
(11,7),
(12,9),
(13,2),
(14,6),
(15,7),
(16,4),
(17,9),
(18,8),
(19,19),
(20,18);