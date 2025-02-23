<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP BD-Fletnix</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-gray-900 text-white">
    <!-- PHP -->
    <?php
        // Configuration de connexion à la base de données
        $servername = "localhost";
        $username = "ericfourmaux"; // Utilisateur par défaut de PHPMyAdmin
        $password = "L1m01!ou"; // Mot de passe vide par défaut
        $dbname = "ERICFOURMAUX"; // Nom de votre base de données

        // Création de connexion
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Test de connexion
        if ($conn->connect_error) {
            die("Connexion échouée: " . $conn->connect_error);
        }
        $conn->set_charset("utf8");
    ?>
    <!-- FIN DU PHP -->
    <?php
    // Fonction pour récupérer les films (tous ou un spécifique)
    function getFilmDetails($conn, $filmId = null) {
        $sqlBase = "SELECT f.codeFilm, f.titre, f.duree, 
                    f.noteGlobale, f.description, 
                    cp.nomCompagnie AS nomCompagnie,
                    l.nomLangue AS langueOriginale
                    FROM FILM f
                    LEFT JOIN COMPAGNIE cp ON f.codeCompagnie = cp.codeCompagnie
                    LEFT JOIN LANGUE l ON f.langueOriginale = l.codeLangue";

        if ($filmId === null) {
            $sql = $sqlBase;
            $result = $conn->query($sql);
        } else {
            $sql = $sqlBase . " WHERE f.codeFilm = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $filmId);
            $stmt->execute();
            $result = $stmt->get_result();
        }

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC); // Retourne tous les films sous forme de tableau associatif
        } else {
            return "<p class='text-red-500'>Film introuvable !</p>";
        }
    }

    function getFilmsByCategory($conn, $categorie) {
        $sql = "SELECT f.codeFilm, f.titre, f.duree, f.noteGlobale, f.description, 
                       cp.nomCompagnie AS nomCompagnie, l.nomLangue AS langueOriginale
                FROM FILM f
                LEFT JOIN COMPAGNIE cp ON f.codeCompagnie = cp.codeCompagnie
                LEFT JOIN LANGUE l ON f.langueOriginale = l.codeLangue
                INNER JOIN FILM_CATEGORIE fc ON f.codeFilm = fc.codeFilm
                INNER JOIN CATEGORIE c ON fc.codeCategorie = c.codeCategorie
                WHERE c.nomCategorie = ?";
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $categorie);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $films = [];
        while ($row = $result->fetch_assoc()) {
            $films[] = $row;
        }
    
        return $films;
    }

    function getActorsAndCrewByFilm($conn, $filmId) {
        $actorsQuery = "SELECT 
                            p.codePersonne AS personneCodePersonne,
                            p.prenom AS personnePrenom,
                            p.nom AS personneNom,
                            af.nomPersonnage AS acteurNomPersonnage
                        FROM ACTEUR_FILM af
                        INNER JOIN PERSONNE p ON af.codePersonne = p.codePersonne
                        WHERE af.codeFilm = ?";
    
        $staffQuery = "SELECT 
                            p.codePersonne AS personneCodePersonne,
                            p.prenom AS personnePrenom,
                            p.nom AS personneNom,
                            tt.nomTypeTravail AS nomTypeTravail
                        FROM STAFF_FILM sf
                        INNER JOIN PERSONNE p ON sf.codePersonne = p.codePersonne
                        INNER JOIN TYPE_TRAVAIL tt ON sf.codeTypeTravail = tt.codeTypeTravail
                        WHERE sf.codeFilm = ?";
    
        // Récupération des acteurs
        $stmt = $conn->prepare($actorsQuery);
        $stmt->bind_param("s", $filmId);
        $stmt->execute();
        $result = $stmt->get_result();
        $actors = [];
        while ($row = $result->fetch_assoc()) {
            $actors[] = $row;
        }
    
        // Récupération de l'équipe technique
        $stmt = $conn->prepare($staffQuery);
        $stmt->bind_param("s", $filmId);
        $stmt->execute();
        $result = $stmt->get_result();
        $staff = [];
        while ($row = $result->fetch_assoc()) {
            $staff[] = $row;
        }
    
        return [
            "acteurs" => $actors,
            "equipe" => $staff
        ];
    }
    
    ?>

    <!-- Navigation -->
    <nav class="bg-gray-800 fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="#" class="text-2xl font-bold flx-pink" style="color: #EF5DA8;">Fletnix</a>
                    <div class="ml-10 flex space-x-8">
                        <a href="index.php" class="text-gray-300 hover:text-white">Accueil</a>
                        <a href="requetes.php" class="text-gray-300 hover:text-white">Travail demandé</a>
                        <a href="films.php" class="text-gray-300 hover:text-white">Catalogue</a>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="ml-4 relative">
                        <button class="flex items-center">
                            <img class="h-8 w-8 rounded-full" 
                                 src="images/avatar_eric.svg" 
                                 alt="Profile">
                            <span class="ml-2"><?php echo htmlspecialchars($username, ENT_QUOTES | ENT_HTML401, 'UTF-8'); ?></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative pt-16">
        <div class="absolute inset-0">
            <img src="images/hero-background.jpg" 
                 class="w-full h-[600px] object-cover" 
                 alt="Background">
            <div class="absolute inset-0 bg-gradient-to-r from-gray-900"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 py-32">
            <h1 class="text-4xl font-bold tracking-tight sm:text-5xl md:text-6xl">
                Les meilleurs films
                <span class="block flx-pink">à portée de clic</span>
            </h1>
            <p class="mt-6 max-w-lg text-xl text-gray-300">
                Découvrez des milliers de films, nouveautés, classiques, séries et plus encore.
            </p>
            <div class="mt-10">
                <a href="#" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md flx-pinkBg hover:bg-red-700">
                    Commencer à regarder
                    <i class="fas fa-play ml-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Films Populaires -->
    <section class="max-w-7xl mx-auto px-4 py-12">
        <h2 class="text-2xl font-semibold mb-6">Films Populaires</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
        <?php $films = getFilmDetails($conn); ?>
        <?php if (!empty($films)): ?>
            <?php foreach ($films as $film): ?>
                <div class="relative group">
                    <img src="images/films/<?php echo htmlspecialchars($film['codeFilm'] ?? '1', ENT_QUOTES, 'UTF-8'); ?>.jpg" 
                        class="rounded-lg w-full h-72 object-cover transform transition duration-300 group-hover:scale-105"
                        alt="<?php echo htmlspecialchars($film['titre']); ?>">
                    <div class="absolute inset-0 bg-gradient-to-t from-black opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-lg">
                        <div class="absolute bottom-0 p-4">
                            <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($film['titre']); ?></h3>
                            <div class="flex items-center mt-2">
                                <div class="flex items-center">
                                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                                    <span><?php echo number_format($film['noteGlobale']/20, 1); ?>/5</span>
                                </div>
                                <span class="mx-2">•</span>
                                <span><?php echo $film['duree']; ?> min</span>
                            </div>
                            <button class="mt-3 w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-md transition duration-300">
                                Regarder
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun film trouvé.</p>
        <?php endif; ?>
        </div>
    </section>

    <!-- Catégories -->
    <section class="max-w-7xl mx-auto px-4 py-12">
        <h2 class="text-2xl font-semibold mb-6">Parcourir par catégorie</h2>

        <?php
            $categories = ['Action', 'Comédie', 'Drame', 'Science-Fiction']; 
            foreach ($categories as $categorie): 
            $films = getFilmsByCategory($conn, $categorie);
            if (empty($films)) continue;
        ?>
            <section class="mb-6 px-8">
                <h2 class="text-2xl font-bold mb-2"><?= htmlspecialchars($categorie, ENT_QUOTES, 'UTF-8') ?></h2>
                <div class="relative group">

                    
                    <!-- Liste des films -->
                    <div id="carousel-<?= md5($categorie) ?>" class="flex overflow-x-scroll no-scrollbar space-x-4 scroll-smooth">
                        <?php foreach ($films as $film): ?>
                            <div class="min-w-[200px] relative">
                                <img src="<?= htmlspecialchars("images/films/{$film['codeFilm']}.jpg", ENT_QUOTES, 'UTF-8') ?>" 
                                    alt="<?= htmlspecialchars($film['titre'], ENT_QUOTES, 'UTF-8') ?>" 
                                    class="rounded-lg w-full h-60 object-cover transform transition duration-300 hover:scale-105" 
                                    onclick="openModal('modal-<?= $film['codeFilm'] ?>')" 
                                    onerror="this.onerror=null; this.src='affiches/placeholder.jpg';">
                                
                                <div class="absolute bottom-0 bg-black bg-opacity-50 w-full p-2 text-center">
                                    <h3 class="text-sm font-semibold"><?= htmlspecialchars($film['titre'], ENT_QUOTES, 'UTF-8') ?></h3>
                                </div>

                                <!-- Modale cachée -->
                                <div id="modal-<?= $film['codeFilm'] ?>" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-888">
                                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full relative">
                                        <!-- Bouton Fermer -->
                                        <button class="absolute top-2 right-2 text-gray-700 hover:text-red-500 text-2xl font-bold"
                                                onclick="closeModal('modal-<?= $film['codeFilm'] ?>')">&times;</button>

                                        <!-- Contenu du film -->
                                        <h2 class="text-xl font-bold text-gray-800"><?= htmlspecialchars($film['titre'], ENT_QUOTES, 'UTF-8') ?></h2>
                                        <p class="text-gray-600 italic"><?= htmlspecialchars($film['description'], ENT_QUOTES, 'UTF-8') ?></p>
                                        <p class="mt-2 text-gray-800"><strong>Compagnie :</strong> <?= htmlspecialchars($film['nomCompagnie'], ENT_QUOTES, 'UTF-8') ?></p>
                                        <p class="text-gray-800"><strong>Durée :</strong> <?= htmlspecialchars($film['duree'], ENT_QUOTES, 'UTF-8') ?> min</p>
                                        <p class="text-gray-800"><strong>Note :</strong> ⭐ <?= htmlspecialchars($film['noteGlobale'], ENT_QUOTES, 'UTF-8') ?>%</p>

                                        <!-- Liste des acteurs et équipe -->
                                        <?php 
                                            $filmData = getActorsAndCrewByFilm($conn, $film['codeFilm']); 
                                            $acteurs = $filmData['acteurs'];
                                            $equipe = $filmData['equipe'];
                                        ?>

                                        <ul class="list-disc pl-5 text-gray-700">
                                            <h3 class="mt-4 text-lg text-gray-800 font-semibold">Équipe</h3>
                                            <?php foreach ($equipe as $membre): ?>
                                                <li>
                                                    <?= htmlspecialchars($membre['nomTypeTravail'] ?? '', ENT_QUOTES, 'UTF-8') ?> - 
                                                    <?= htmlspecialchars($membre['personnePrenom'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                                    <?= htmlspecialchars($membre['personneNom'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                                </li>
                                            <?php endforeach; ?>

                                            <h3 class="mt-4 text-lg text-gray-800 font-semibold">Acteurs</h3>
                                            <?php foreach ($acteurs as $acteur): ?>
                                                <li>
                                                    <?= htmlspecialchars($acteur['personnePrenom'] ?? '', ENT_QUOTES, 'UTF-8') ?> 
                                                    <?= htmlspecialchars($acteur['personneNom'] ?? '', ENT_QUOTES, 'UTF-8') ?> - 
                                                    <span class="text-green-600 italic">
                                                        <?= htmlspecialchars($acteur['acteurNomPersonnage'] ?? 'Inconnu', ENT_QUOTES, 'UTF-8') ?>
                                                    </span>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>



                </div>
            </section>
        <?php endforeach; ?>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 mt-12">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">À propos</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Qui sommes-nous</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Carrières</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Aide</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Support technique</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Conditions d'utilisation</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Légal</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Confidentialité</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Cookies</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Suivez-nous</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-700 text-center text-gray-400">
                <p>Fletnix - Eric Fourmaux - RAC Cégep Limoilou</p>
            </div>
        </div>
    </footer>

    <script>
        // Animation du menu au scroll
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 0) {
                nav.classList.add('bg-opacity-95');
            } else {
                nav.classList.remove('bg-opacity-95');
            }
        });

        // Gestion de la modale
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.getElementById(id).classList.add('flex');
            document.body.classList.add('overflow-hidden'); // Supprime la barre de scroll
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.getElementById(id).classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }
    </script>
    
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</body>
</html>