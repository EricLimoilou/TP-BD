-- 1- Client ayant commandé le plus de films
SELECT nomCLIENT, prenomCLIENT 
FROM Client 
JOIN Commande ON Client.codeCLIENT = Commande.codeCLIENT 
GROUP BY Client.codeCLIENT 
ORDER BY COUNT(Commande.idCommande) DESC 
LIMIT 1;

-- 2- Clients dont la carte expire dans moins de 3 mois
SELECT nomCLIENT, prenomCLIENT 
FROM Client 
JOIN CarteCredit ON Client.codeCLIENT = CarteCredit.codeCLIENT 
WHERE expiration < DATE_ADD(CURDATE(), INTERVAL 3 MONTH);

-- 3- Acteurs du film avec la meilleure note
SELECT nomActeur, prenomActeur 
FROM Acteur 
JOIN FilmActeur ON Acteur.idActeur = FilmActeur.idActeur 
WHERE FilmActeur.idFilm = (SELECT idFilm FROM Film ORDER BY noteGlobale DESC LIMIT 1);

-- 4- Films jamais commandés
SELECT nomFilm 
FROM Film 
WHERE idFilm NOT IN (SELECT DISTINCT idFilm FROM Commande);

-- 5- Films d'action et leur note
SELECT nomFilm, noteGlobale 
FROM Film 
JOIN FilmCategorie ON Film.idFilm = FilmCategorie.idFilm 
JOIN Categorie ON FilmCategorie.idCategorie = Categorie.idCategorie 
WHERE Categorie.nomCategorie = 'Action';

-- 6- Mise à jour d’une note
UPDATE Note 
SET note = 90 
WHERE codeCLIENT = (SELECT codeCLIENT FROM Client WHERE emailCLIENT = 'exemple@email.com') 
AND idFilm = (SELECT idFilm FROM Film WHERE nomFilm = 'NomDuFilm');

-- 7- Retrait d’une note
DELETE FROM Note 
WHERE codeCLIENT = (SELECT codeCLIENT FROM Client WHERE emailCLIENT = 'exemple@email.com') 
AND idFilm = (SELECT idFilm FROM Film WHERE nomFilm = 'NomDuFilm');