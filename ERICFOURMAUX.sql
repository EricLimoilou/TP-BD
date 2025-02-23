-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : dim. 23 fév. 2025 à 12:01
-- Version du serveur : 8.0.40
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ERICFOURMAUX`
--

-- --------------------------------------------------------

--
-- Structure de la table `ACTEUR_FILM`
--

CREATE TABLE `ACTEUR_FILM` (
  `codeFilm` int NOT NULL,
  `codePersonne` int NOT NULL,
  `nomPersonnage` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date DEFAULT NULL,
  `cachet` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ACTEUR_FILM`
--

INSERT INTO `ACTEUR_FILM` (`codeFilm`, `codePersonne`, `nomPersonnage`, `dateDebut`, `dateFin`, `cachet`) VALUES
(1, 1, 'Simba adulte', '2018-03-01', '2018-08-15', 8000000.00),
(2, 2, 'Dr. Ellie Sattler', '1992-05-10', '1992-12-20', 5000000.00),
(3, 1, 'Dom Cobb', '2009-04-15', '2010-01-25', 12000000.00),
(4, 1, 'Jack Dawson', '1996-07-01', '1997-03-31', 2500000.00),
(5, 5, 'Ki-jung', '2018-09-05', '2019-02-28', 1500000.00),
(6, 2, 'Black Widow', '2018-02-01', '2019-05-31', 15000000.00);

-- --------------------------------------------------------

--
-- Structure de la table `CARTE_CREDIT`
--

CREATE TABLE `CARTE_CREDIT` (
  `codeCarte` int NOT NULL,
  `codeClient` int NOT NULL,
  `numeroCarte` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateExpiration` date NOT NULL,
  `nomTitulaire` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codeSecurite` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estParDefaut` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `CARTE_CREDIT`
--

INSERT INTO `CARTE_CREDIT` (`codeCarte`, `codeClient`, `numeroCarte`, `dateExpiration`, `nomTitulaire`, `codeSecurite`, `estParDefaut`) VALUES
(1, 1, '1234567890123456', '2024-05-31', 'Jean Dupont', '123', 1),
(2, 2, '2345678901234567', '2024-08-31', 'Sophie Martin', '234', 1),
(3, 3, '3456789012345678', '2024-03-31', 'Philippe Leclerc', '345', 1),
(4, 4, '4567890123456789', '2025-01-31', 'Marie Petit', '456', 1),
(5, 5, '5678901234567890', '2025-04-30', 'Paul Dubois', '567', 1),
(6, 1, '6789012345678901', '2026-06-30', 'Jean Dupont', '678', 0);

-- --------------------------------------------------------

--
-- Structure de la table `CATEGORIE`
--

CREATE TABLE `CATEGORIE` (
  `codeCategorie` int NOT NULL,
  `nomCategorie` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `CATEGORIE`
--

INSERT INTO `CATEGORIE` (`codeCategorie`, `nomCategorie`, `description`) VALUES
(1, 'Action', 'Films avec des scènes d\'action, des cascades, des combats.'),
(2, 'Aventure', 'Films centrés sur un voyage ou une quête.'),
(3, 'Comédie', 'Films humoristiques.'),
(4, 'Drame', 'Films sérieux ou réalistes abordant des sujets émotionnels.'),
(5, 'Science-Fiction', 'Films incorporant des éléments scientifiques et technologiques futuristes.'),
(6, 'Horreur', 'Films destinés à effrayer le spectateur.'),
(7, 'Romance', 'Films centrés sur des relations amoureuses.');

-- --------------------------------------------------------

--
-- Structure de la table `CLIENT`
--

CREATE TABLE `CLIENT` (
  `codeClient` int NOT NULL,
  `passwordClient` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomClient` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenomClient` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codePostal` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pays` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `courriel` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateInscription` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `CLIENT`
--

INSERT INTO `CLIENT` (`codeClient`, `passwordClient`, `nomClient`, `prenomClient`, `adresse`, `ville`, `codePostal`, `pays`, `telephone`, `courriel`, `dateInscription`) VALUES
(1, 'password123', 'Dupont', 'Jean', '123 rue de Paris', 'Paris', '75001', 'France', '0123456789', 'jean.dupont@email.com', '2023-01-15'),
(2, 'securePass', 'Martin', 'Sophie', '456 Avenue des Lilas', 'Lyon', '69002', 'France', '0234567890', 'sophie.martin@email.com', '2023-02-20'),
(3, 'myP@ssw0rd', 'Leclerc', 'Philippe', '789 Boulevard Victor Hugo', 'Marseille', '13008', 'France', '0345678901', 'philippe.leclerc@email.com', '2023-03-10'),
(4, 'p@ssword1', 'Petit', 'Marie', '101 Rue des Fleurs', 'Toulouse', '31000', 'France', '0456789012', 'marie.petit@email.com', '2023-04-05'),
(5, 'strongPwd2', 'Dubois', 'Paul', '202 Avenue de la République', 'Bordeaux', '33000', 'France', '0567890123', 'paul.dubois@email.com', '2023-05-12'),
(6, 'userPass3', 'Moreau', 'Claire', '303 Rue de la Liberté', 'Lille', '59000', 'France', '0678901234', 'claire.moreau@email.com', '2023-06-18');

-- --------------------------------------------------------

--
-- Structure de la table `COMMANDE`
--

CREATE TABLE `COMMANDE` (
  `codeCommande` int NOT NULL,
  `codeClient` int NOT NULL,
  `codeFilm` int NOT NULL,
  `dateCommande` datetime NOT NULL,
  `adresseIP` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempsVisionnement` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `COMMANDE`
--

INSERT INTO `COMMANDE` (`codeCommande`, `codeClient`, `codeFilm`, `dateCommande`, `adresseIP`, `tempsVisionnement`) VALUES
(0, 1, 2, '2023-06-30 21:15:45', '192.168.1.101', 2700),
(1, 1, 1, '2023-06-01 20:15:30', '192.168.1.100', 3600),
(2, 1, 3, '2023-06-05 21:30:45', '192.168.1.100', 7200),
(3, 2, 2, '2023-06-10 19:45:20', '192.168.2.200', 5400),
(4, 3, 4, '2023-06-15 22:10:15', '192.168.3.150', 9000),
(5, 4, 5, '2023-06-20 18:30:00', '192.168.4.175', 4800),
(6, 5, 6, '2023-06-25 20:00:30', '192.168.5.225', 6300);

-- --------------------------------------------------------

--
-- Structure de la table `COMPAGNIE`
--

CREATE TABLE `COMPAGNIE` (
  `codeCompagnie` int NOT NULL,
  `nomCompagnie` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `COMPAGNIE`
--

INSERT INTO `COMPAGNIE` (`codeCompagnie`, `nomCompagnie`, `description`) VALUES
(1, 'Disney', 'The Walt Disney Company est une entreprise américaine créée en 1923.'),
(2, 'Universal Pictures', 'Universal Pictures est un studio de cinéma américain qui fait partie du groupe Universal Studios.'),
(3, 'Warner Bros', 'Warner Bros. Entertainment est l\'une des plus grandes sociétés de production de films et de télévision au monde.'),
(4, 'Paramount Pictures', 'Paramount Pictures Corporation est un studio de cinéma et de télévision américain.'),
(5, 'Sony Pictures', 'Sony Pictures Entertainment est une société américaine de production et de distribution de films.');

-- --------------------------------------------------------

--
-- Structure de la table `FILM`
--

CREATE TABLE `FILM` (
  `codeFilm` int NOT NULL,
  `codeCompagnie` int NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duree` int NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `noteGlobale` decimal(4,2) DEFAULT NULL,
  `dateAjout` date NOT NULL,
  `langueOriginale` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `FILM`
--

INSERT INTO `FILM` (`codeFilm`, `codeCompagnie`, `titre`, `duree`, `description`, `noteGlobale`, `dateAjout`, `langueOriginale`) VALUES
(1, 1, 'Le Roi Lion', 118, 'Un jeune lion prince est évincé de son royaume par son oncle cruel, qui prétend vouloir mettre fin au règne de la terreur de son père.', 92.50, '2023-01-01', 2),
(2, 2, 'Jurassic Park', 127, 'Un milliardaire et son équipe de scientifiques génétiques créent un parc d\'attractions peuplé de dinosaures recréés à partir d\'ADN préhistorique.', 91.00, '2023-01-15', 2),
(3, 3, 'Inception', 148, 'Un voleur qui commet des crimes d\'entreprise en utilisant une technologie qui lui permet de pénétrer le subconscient de ses cibles se voit proposer une chance de retrouver son ancienne vie.', 95.50, '2023-02-01', 2),
(4, 4, 'Titanic', 194, 'Une aristocrate de dix-sept ans tombe amoureuse d\'un artiste à bord du luxueux et infortuné R.M.S. Titanic.', 87.80, '2023-02-15', 2),
(5, 5, 'Parasite', 132, 'Greed and class discrimination threaten the relationship between the wealthy Park family and the destitute Kim clan.', 96.20, '2023-03-01', 5),
(6, 1, 'Avengers: Endgame', 181, 'Après les événements dévastateurs d\'Infinity War, l\'univers est en ruines. Avec l\'aide des alliés restants, les Avengers se rassemblent une fois de plus.', 94.30, '2023-03-15', 2);

-- --------------------------------------------------------

--
-- Structure de la table `FILMS_SIMILAIRES`
--

CREATE TABLE `FILMS_SIMILAIRES` (
  `codeFilm` int NOT NULL,
  `codeFilmSimilaire` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `FILMS_SIMILAIRES`
--

INSERT INTO `FILMS_SIMILAIRES` (`codeFilm`, `codeFilmSimilaire`) VALUES
(5, 1),
(1, 2),
(2, 3),
(3, 5),
(4, 6);

-- --------------------------------------------------------

--
-- Structure de la table `FILM_CATEGORIE`
--

CREATE TABLE `FILM_CATEGORIE` (
  `codeFilm` int NOT NULL,
  `codeCategorie` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `FILM_CATEGORIE`
--

INSERT INTO `FILM_CATEGORIE` (`codeFilm`, `codeCategorie`) VALUES
(2, 1),
(3, 1),
(6, 1),
(1, 2),
(2, 2),
(3, 2),
(6, 2),
(1, 3),
(5, 3),
(4, 4),
(5, 4),
(2, 5),
(3, 5),
(6, 5),
(4, 7);

-- --------------------------------------------------------

--
-- Structure de la table `FILM_LANGUE`
--

CREATE TABLE `FILM_LANGUE` (
  `codeFilm` int NOT NULL,
  `codeLangue` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `FILM_LANGUE`
--

INSERT INTO `FILM_LANGUE` (`codeFilm`, `codeLangue`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(1, 3),
(6, 3),
(2, 4),
(6, 4),
(5, 5),
(3, 6),
(4, 7);

-- --------------------------------------------------------

--
-- Structure de la table `LANGUE`
--

CREATE TABLE `LANGUE` (
  `codeLangue` int NOT NULL,
  `nomLangue` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `LANGUE`
--

INSERT INTO `LANGUE` (`codeLangue`, `nomLangue`) VALUES
(1, 'Français'),
(2, 'Anglais'),
(3, 'Espagnol'),
(4, 'Mandarin'),
(5, 'Japonais'),
(6, 'Allemand'),
(7, 'Italien');

-- --------------------------------------------------------

--
-- Structure de la table `NOTE`
--

CREATE TABLE `NOTE` (
  `codeNote` int NOT NULL,
  `codeClient` int NOT NULL,
  `codeFilm` int NOT NULL,
  `note` int NOT NULL,
  `commentaire` text COLLATE utf8mb4_unicode_ci,
  `dateNote` datetime NOT NULL
) ;

--
-- Déchargement des données de la table `NOTE`
--

INSERT INTO `NOTE` (`codeNote`, `codeClient`, `codeFilm`, `note`, `commentaire`, `dateNote`) VALUES
(1, 1, 1, 95, 'Excellent film pour toute la famille.', '2023-06-02 10:30:00'),
(2, 1, 3, 98, 'Un chef-d\'œuvre de science-fiction.', '2023-06-06 14:45:30'),
(3, 2, 2, 90, 'Effets spéciaux incroyables pour l\'époque.', '2023-06-11 09:15:20'),
(4, 3, 4, 85, 'Une belle histoire d\'amour, mais un peu long.', '2023-06-16 16:20:10'),
(5, 4, 5, 97, 'Film profond sur les inégalités sociales.', '2023-06-21 11:30:45');

-- --------------------------------------------------------

--
-- Structure de la table `PERSONNE`
--

CREATE TABLE `PERSONNE` (
  `codePersonne` int NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateNaissance` date DEFAULT NULL,
  `biographie` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `PERSONNE`
--

INSERT INTO `PERSONNE` (`codePersonne`, `nom`, `prenom`, `dateNaissance`, `biographie`) VALUES
(1, 'DiCaprio', 'Leonardo', '1974-11-11', 'Acteur américain connu pour ses rôles dans Titanic et The Revenant.'),
(2, 'Johansson', 'Scarlett', '1984-11-22', 'Actrice américaine connue pour son rôle de Black Widow.'),
(3, 'Spielberg', 'Steven', '1946-12-18', 'Réalisateur américain connu pour E.T. et Jurassic Park.'),
(4, 'Nolan', 'Christopher', '1970-07-30', 'Réalisateur britannique-américain connu pour Inception et Interstellar.'),
(5, 'Portman', 'Natalie', '1981-06-09', 'Actrice israélo-américaine connue pour Black Swan.'),
(6, 'Pitt', 'Brad', '1963-12-18', 'Acteur américain connu pour Fight Club et Once Upon a Time in Hollywood.'),
(7, 'Lawrence', 'Jennifer', '1990-08-15', 'Actrice américaine connue pour Hunger Games.'),
(8, 'Tarantino', 'Quentin', '1963-03-27', 'Réalisateur américain connu pour Pulp Fiction et Kill Bill.'),
(9, 'Gosling', 'Ryan', '1980-11-12', 'Acteur canadien connu pour La La Land et Drive.'),
(10, 'Zimmer', 'Hans', '1957-09-12', 'Compositeur allemand de musiques de films.');

-- --------------------------------------------------------

--
-- Structure de la table `STAFF_FILM`
--

CREATE TABLE `STAFF_FILM` (
  `codeFilm` int NOT NULL,
  `codePersonne` int NOT NULL,
  `codeTypeTravail` int NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date DEFAULT NULL,
  `salaire` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `STAFF_FILM`
--

INSERT INTO `STAFF_FILM` (`codeFilm`, `codePersonne`, `codeTypeTravail`, `dateDebut`, `dateFin`, `salaire`) VALUES
(1, 3, 1, '2017-10-01', '2019-01-31', 10000000.00),
(2, 3, 1, '1991-08-15', '1993-05-31', 8000000.00),
(3, 4, 1, '2008-06-01', '2010-03-31', 15000000.00),
(3, 4, 3, '2008-01-15', '2008-05-31', 5000000.00),
(4, 8, 3, '1995-09-01', '1996-06-30', 3000000.00),
(5, 10, 5, '2018-06-01', '2018-12-31', 1000000.00);

-- --------------------------------------------------------

--
-- Structure de la table `TYPE_TRAVAIL`
--

CREATE TABLE `TYPE_TRAVAIL` (
  `codeTypeTravail` int NOT NULL,
  `nomTypeTravail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `TYPE_TRAVAIL`
--

INSERT INTO `TYPE_TRAVAIL` (`codeTypeTravail`, `nomTypeTravail`) VALUES
(5, 'Compositeur'),
(7, 'Costumier'),
(4, 'Directeur de la photographie'),
(6, 'Monteur'),
(2, 'Producteur'),
(1, 'Réalisateur'),
(3, 'Scénariste');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ACTEUR_FILM`
--
ALTER TABLE `ACTEUR_FILM`
  ADD PRIMARY KEY (`codeFilm`,`codePersonne`),
  ADD KEY `codePersonne` (`codePersonne`);

--
-- Index pour la table `CARTE_CREDIT`
--
ALTER TABLE `CARTE_CREDIT`
  ADD PRIMARY KEY (`codeCarte`),
  ADD KEY `codeClient` (`codeClient`),
  ADD KEY `idx_carte_expiration` (`dateExpiration`);

--
-- Index pour la table `CATEGORIE`
--
ALTER TABLE `CATEGORIE`
  ADD PRIMARY KEY (`codeCategorie`),
  ADD UNIQUE KEY `nomCategorie` (`nomCategorie`);

--
-- Index pour la table `CLIENT`
--
ALTER TABLE `CLIENT`
  ADD PRIMARY KEY (`codeClient`),
  ADD UNIQUE KEY `courriel` (`courriel`),
  ADD KEY `idx_client_courriel` (`courriel`);

--
-- Index pour la table `COMMANDE`
--
ALTER TABLE `COMMANDE`
  ADD PRIMARY KEY (`codeCommande`),
  ADD KEY `codeClient` (`codeClient`),
  ADD KEY `codeFilm` (`codeFilm`);

--
-- Index pour la table `COMPAGNIE`
--
ALTER TABLE `COMPAGNIE`
  ADD PRIMARY KEY (`codeCompagnie`);

--
-- Index pour la table `FILM`
--
ALTER TABLE `FILM`
  ADD PRIMARY KEY (`codeFilm`),
  ADD KEY `codeCompagnie` (`codeCompagnie`),
  ADD KEY `langueOriginale` (`langueOriginale`),
  ADD KEY `idx_film_titre` (`titre`);

--
-- Index pour la table `FILMS_SIMILAIRES`
--
ALTER TABLE `FILMS_SIMILAIRES`
  ADD PRIMARY KEY (`codeFilm`,`codeFilmSimilaire`),
  ADD KEY `codeFilmSimilaire` (`codeFilmSimilaire`);

--
-- Index pour la table `FILM_CATEGORIE`
--
ALTER TABLE `FILM_CATEGORIE`
  ADD PRIMARY KEY (`codeFilm`,`codeCategorie`),
  ADD KEY `codeCategorie` (`codeCategorie`);

--
-- Index pour la table `FILM_LANGUE`
--
ALTER TABLE `FILM_LANGUE`
  ADD PRIMARY KEY (`codeFilm`,`codeLangue`),
  ADD KEY `codeLangue` (`codeLangue`);

--
-- Index pour la table `LANGUE`
--
ALTER TABLE `LANGUE`
  ADD PRIMARY KEY (`codeLangue`);

--
-- Index pour la table `NOTE`
--
ALTER TABLE `NOTE`
  ADD PRIMARY KEY (`codeNote`),
  ADD UNIQUE KEY `codeClient` (`codeClient`,`codeFilm`),
  ADD KEY `codeFilm` (`codeFilm`);

--
-- Index pour la table `PERSONNE`
--
ALTER TABLE `PERSONNE`
  ADD PRIMARY KEY (`codePersonne`);

--
-- Index pour la table `STAFF_FILM`
--
ALTER TABLE `STAFF_FILM`
  ADD PRIMARY KEY (`codeFilm`,`codePersonne`,`codeTypeTravail`),
  ADD KEY `codePersonne` (`codePersonne`),
  ADD KEY `codeTypeTravail` (`codeTypeTravail`);

--
-- Index pour la table `TYPE_TRAVAIL`
--
ALTER TABLE `TYPE_TRAVAIL`
  ADD PRIMARY KEY (`codeTypeTravail`),
  ADD UNIQUE KEY `nomTypeTravail` (`nomTypeTravail`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `CARTE_CREDIT`
--
ALTER TABLE `CARTE_CREDIT`
  MODIFY `codeCarte` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `CATEGORIE`
--
ALTER TABLE `CATEGORIE`
  MODIFY `codeCategorie` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `CLIENT`
--
ALTER TABLE `CLIENT`
  MODIFY `codeClient` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `COMMANDE`
--
ALTER TABLE `COMMANDE`
  MODIFY `codeCommande` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `COMPAGNIE`
--
ALTER TABLE `COMPAGNIE`
  MODIFY `codeCompagnie` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `FILM`
--
ALTER TABLE `FILM`
  MODIFY `codeFilm` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `LANGUE`
--
ALTER TABLE `LANGUE`
  MODIFY `codeLangue` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `NOTE`
--
ALTER TABLE `NOTE`
  MODIFY `codeNote` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `PERSONNE`
--
ALTER TABLE `PERSONNE`
  MODIFY `codePersonne` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `TYPE_TRAVAIL`
--
ALTER TABLE `TYPE_TRAVAIL`
  MODIFY `codeTypeTravail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `ACTEUR_FILM`
--
ALTER TABLE `ACTEUR_FILM`
  ADD CONSTRAINT `acteur_film_ibfk_1` FOREIGN KEY (`codeFilm`) REFERENCES `FILM` (`codeFilm`) ON DELETE CASCADE,
  ADD CONSTRAINT `acteur_film_ibfk_2` FOREIGN KEY (`codePersonne`) REFERENCES `PERSONNE` (`codePersonne`);

--
-- Contraintes pour la table `CARTE_CREDIT`
--
ALTER TABLE `CARTE_CREDIT`
  ADD CONSTRAINT `carte_credit_ibfk_1` FOREIGN KEY (`codeClient`) REFERENCES `CLIENT` (`codeClient`) ON DELETE CASCADE;

--
-- Contraintes pour la table `COMMANDE`
--
ALTER TABLE `COMMANDE`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`codeClient`) REFERENCES `CLIENT` (`codeClient`) ON DELETE CASCADE,
  ADD CONSTRAINT `commande_ibfk_2` FOREIGN KEY (`codeFilm`) REFERENCES `FILM` (`codeFilm`);

--
-- Contraintes pour la table `FILM`
--
ALTER TABLE `FILM`
  ADD CONSTRAINT `film_ibfk_1` FOREIGN KEY (`codeCompagnie`) REFERENCES `COMPAGNIE` (`codeCompagnie`),
  ADD CONSTRAINT `film_ibfk_2` FOREIGN KEY (`langueOriginale`) REFERENCES `LANGUE` (`codeLangue`);

--
-- Contraintes pour la table `FILMS_SIMILAIRES`
--
ALTER TABLE `FILMS_SIMILAIRES`
  ADD CONSTRAINT `films_similaires_ibfk_1` FOREIGN KEY (`codeFilm`) REFERENCES `FILM` (`codeFilm`) ON DELETE CASCADE,
  ADD CONSTRAINT `films_similaires_ibfk_2` FOREIGN KEY (`codeFilmSimilaire`) REFERENCES `FILM` (`codeFilm`) ON DELETE CASCADE;

--
-- Contraintes pour la table `FILM_CATEGORIE`
--
ALTER TABLE `FILM_CATEGORIE`
  ADD CONSTRAINT `film_categorie_ibfk_1` FOREIGN KEY (`codeFilm`) REFERENCES `FILM` (`codeFilm`) ON DELETE CASCADE,
  ADD CONSTRAINT `film_categorie_ibfk_2` FOREIGN KEY (`codeCategorie`) REFERENCES `CATEGORIE` (`codeCategorie`);

--
-- Contraintes pour la table `FILM_LANGUE`
--
ALTER TABLE `FILM_LANGUE`
  ADD CONSTRAINT `film_langue_ibfk_1` FOREIGN KEY (`codeFilm`) REFERENCES `FILM` (`codeFilm`) ON DELETE CASCADE,
  ADD CONSTRAINT `film_langue_ibfk_2` FOREIGN KEY (`codeLangue`) REFERENCES `LANGUE` (`codeLangue`);

--
-- Contraintes pour la table `NOTE`
--
ALTER TABLE `NOTE`
  ADD CONSTRAINT `note_ibfk_1` FOREIGN KEY (`codeClient`) REFERENCES `CLIENT` (`codeClient`) ON DELETE CASCADE,
  ADD CONSTRAINT `note_ibfk_2` FOREIGN KEY (`codeFilm`) REFERENCES `FILM` (`codeFilm`) ON DELETE CASCADE;

--
-- Contraintes pour la table `STAFF_FILM`
--
ALTER TABLE `STAFF_FILM`
  ADD CONSTRAINT `staff_film_ibfk_1` FOREIGN KEY (`codeFilm`) REFERENCES `FILM` (`codeFilm`) ON DELETE CASCADE,
  ADD CONSTRAINT `staff_film_ibfk_2` FOREIGN KEY (`codePersonne`) REFERENCES `PERSONNE` (`codePersonne`),
  ADD CONSTRAINT `staff_film_ibfk_3` FOREIGN KEY (`codeTypeTravail`) REFERENCES `TYPE_TRAVAIL` (`codeTypeTravail`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
