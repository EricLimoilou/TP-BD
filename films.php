<?php
// Connexion à la base de données
$servername = "localhost";
$username = "ericfourmaux"; // Remplacez par votre nom d'utilisateur MySQL
$password = "L1m01!ou"; // Remplacez par votre mot de passe MySQL
$dbname = "ERICFOURMAUX"; // Remplacez par le nom de votre base de données

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

function getFilms($conn) {
    $sql = "SELECT f.codeFilm AS idFilm, 
                   f.titre AS titreFilm, 
                   f.duree AS dureeMinutes, 
                   f.dateAjout, 
                   f.description, f.noteGlobale, l.nomLangue
            FROM FILM f
            LEFT JOIN LANGUE l ON f.langueOriginale = l.codeLangue
            ORDER BY f.dateAjout DESC";

    $result = $conn->query($sql);
    
    $films = [];
    while ($row = $result->fetch_assoc()) {
        $films[] = $row;
    }

    return $films;
}

// Récupération des films
$films = getFilms($conn);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP BD-Fletnix</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-gray-900 text-white">

    <!-- Navigation -->
    <nav class="bg-gray-800 fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="#" class="text-2xl font-bold" style="color: #EF5DA8;">Fletnix</a>
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

    <section class="max-w-7xl mx-auto px-4 py-12">
        &nbsp;
    </section>
    
    <!-- Catalogue de films -->
    <main class="max-w-7xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold text-center mb-8 text-pink-400">Catalogue des films</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php foreach ($films as $film) : ?>
                <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                    <div class="p-4">
                        <h2 class="text-xl font-semibold text-white"><?= htmlspecialchars($film['titreFilm']) ?></h2>
                        <p class="text-gray-400 text-sm">Année : <?= htmlspecialchars($film['dateAjout']) ?> | Durée : <?= htmlspecialchars($film['dureeMinutes']) ?> min</p>
                        <p class="text-gray-300 mt-2 text-sm">Langue : <?= htmlspecialchars($film['nomLangue']) ?></p>
                        <p class="text-gray-300 mt-2"><?= nl2br(htmlspecialchars(substr($film['description'], 0, 100))) ?>...</p>
                        <p class="mt-2 text-yellow-400 font-bold">Note : <?= htmlspecialchars($film['noteGlobale']) ?>/10</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

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
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-700 text-center text-gray-400">
                <p>Fletnix - Eric Fourmaux - RAC Cégep Limoilou</p>
            </div>
        </div>
    </footer>
</body>
</html>
<?php
$conn->close();
?>
