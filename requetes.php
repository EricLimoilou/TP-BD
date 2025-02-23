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

    <main class="max-w-7xl mx-auto px-4 py-12">
    <section class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Section Client -->
            <section class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4 text-indigo-700">Informations Clients</h2>
                
                <!-- Client avec le plus de commandes -->
                <div class="mb-6">
                    <h3 class="font-medium text-gray-700 mb-2">Client avec le plus de commandes</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <!-- PHP -->
                        <?php
                            $query1 = "SELECT c.nomClient, c.prenomClient 
                                    FROM CLIENT c 
                                    JOIN (
                                        SELECT codeClient, COUNT(*) as nombreCommandes 
                                        FROM COMMANDE 
                                        GROUP BY codeClient 
                                        ORDER BY nombreCommandes DESC 
                                        LIMIT 1
                                    ) AS max_commandes 
                                    ON c.codeClient = max_commandes.codeClient";
                            
                            $result1 = $conn->query($query1);
                            
                            if ($result1 && $result1->num_rows > 0) {
                                $row = $result1->fetch_assoc();
                                echo "<p class='text-green-600 font-medium'>{$row['prenomClient']} {$row['nomClient']}</p>";
                            } else {
                                echo "<p class='text-red-500'>Aucun résultat trouvé</p>";
                            }
                        ?>
                        <!-- FIN DU PHP -->
                    </div>
                </div>
                
                <!-- Clients avec carte expirant bientôt -->
                <div>
                    <h3 class="font-medium text-gray-700 mb-2">Clients avec carte expirant dans moins de 3 mois</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <!-- PHP -->
                        <?php
                            $query2 = "SELECT DISTINCT c.nomClient, c.prenomClient, cc.dateExpiration 
                                    FROM CLIENT c 
                                    JOIN CARTE_CREDIT cc ON c.codeClient = cc.codeClient 
                                    WHERE cc.dateExpiration BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 3 MONTH)";
                            
                            $result2 = $conn->query($query2);
                            
                            if ($result2 && $result2->num_rows > 0) {
                                echo "<ul class='space-y-1'>";
                                while ($row = $result2->fetch_assoc()) {
                                    $dateExpiration = new DateTime($row['dateExpiration']);
                                    echo "<li class='text-amber-600'>{$row['prenomClient']} {$row['nomClient']} - 
                                        Expire le " . $dateExpiration->format('d/m/Y') . "</li>";
                                }
                                echo "</ul>";
                            } else {
                                echo "<p class='text-gray-500'>Aucun client avec carte expirant bientôt</p>";
                            }
                        ?>
                        <!-- FIN DU PHP -->
                    </div>
                </div>
            </section>

            <!-- Section Films -->
            <section class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4 text-indigo-700">Informations Films</h2>
                
                <!-- Films d'action -->
                <div class="mb-6">
                    <h3 class="font-medium text-gray-700 mb-2">Films d'action</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <!-- PHP -->
                        <?php
                            $query5 = "SELECT f.titre, f.noteGlobale 
                                    FROM FILM f 
                                    JOIN FILM_CATEGORIE fc ON f.codeFilm = fc.codeFilm 
                                    JOIN CATEGORIE c ON fc.codeCategorie = c.codeCategorie 
                                    WHERE c.nomCategorie = 'Action'";
                            
                            $result5 = $conn->query($query5);
                            
                            if ($result5 && $result5->num_rows > 0) {
                                echo "<div class='overflow-x-auto'>";
                                echo "<table class='min-w-full divide-y divide-gray-200'>";
                                echo "<thead><tr>
                                        <th class='px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'>Titre</th>
                                        <th class='px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'>Note</th>
                                    </tr></thead>";
                                echo "<tbody class='divide-y divide-gray-200'>";
                                
                                while ($row = $result5->fetch_assoc()) {
                                    // Déterminer la classe de couleur selon la note
                                    $noteClass = 'text-red-500';
                                    if ($row['noteGlobale'] >= 80) {
                                        $noteClass = 'text-green-500';
                                    } elseif ($row['noteGlobale'] >= 60) {
                                        $noteClass = 'text-amber-500';
                                    }
                                    
                                    echo "<tr>
                                            <td class='px-3 py-2 whitespace-nowrap text-gray-800'>{$row['titre']}</td>
                                            <td class='px-3 py-2 whitespace-nowrap {$noteClass} font-medium'>{$row['noteGlobale']}%</td>
                                        </tr>";
                                }
                                
                                echo "</tbody></table></div>";
                            } else {
                                echo "<p class='text-gray-500'>Aucun film d'action trouvé</p>";
                            }
                        ?>
                        <!-- FIN DU PHP -->
                    </div>
                </div>
                
                <!-- Films jamais commandés -->
                <div>
                    <h3 class="font-medium text-gray-700 mb-2">Films jamais commandés</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <!-- PHP -->
                        <?php
                            $query4 = "SELECT f.titre FROM FILM f 
                                    LEFT JOIN COMMANDE c ON f.codeFilm = c.codeFilm 
                                    WHERE c.codeCommande IS NULL";
                            
                            $result4 = $conn->query($query4);
                            
                            if ($result4 && $result4->num_rows > 0) {
                                echo "<ul class='space-y-1 text-gray-600'>";
                                while ($row = $result4->fetch_assoc()) {
                                    echo "<li class='flex items-center'>
                                            <svg class='h-4 w-4 text-red-400 mr-1' fill='currentColor' viewBox='0 0 20 20'>
                                                <path fill-rule='evenodd' d='M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z' clip-rule='evenodd'></path>
                                            </svg>
                                            {$row['titre']}
                                        </li>";
                                }
                                echo "</ul>";
                            } else {
                                echo "<p class='text-gray-500'>Tous les films ont été commandés au moins une fois</p>";
                            }
                        ?>
                        <!-- FIN DU PHP -->
                    </div>
                </div>
            </section>
        </div>
        
        <!-- Section Acteurs et Gestion des Notes -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
            <!-- Acteurs du film le mieux noté -->
            <section class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4 text-indigo-700">Acteurs du film le mieux noté</h2>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <!-- PHP -->
                    <?php
                        $query3 = "SELECT p.nom, p.prenom, f.titre, f.noteGlobale 
                                FROM PERSONNE p 
                                JOIN ACTEUR_FILM af ON p.codePersonne = af.codePersonne 
                                JOIN FILM f ON af.codeFilm = f.codeFilm 
                                WHERE f.noteGlobale = (SELECT MAX(noteGlobale) FROM FILM)";
                        
                        $result3 = $conn->query($query3);
                        
                        if ($result3 && $result3->num_rows > 0) {
                            $filmInfo = null;
                            echo "<div class='mb-3'>";
                            
                            // Afficher d'abord le titre du film et sa note
                            $row = $result3->fetch_assoc();
                            $filmInfo = "<p class='font-medium'>Film: <span class='text-indigo-600'>{$row['titre']}</span> - 
                                        Note: <span class='text-green-500'>{$row['noteGlobale']}%</span></p>";
                            echo $filmInfo;
                            
                            // Réinitialiser le pointeur de résultat
                            $result3->data_seek(0);
                            
                            echo "<p class='mt-2 font-medium text-gray-800'>Acteurs:</p>";
                            echo "<ul class='mt-1 space-y-1 ml-4 text-gray-800'>";
                            while ($row = $result3->fetch_assoc()) {
                                echo "<li>• {$row['prenom']} {$row['nom']}</li>";
                            }
                            echo "</ul>";
                            echo "</div>";
                        } else {
                            echo "<p class='text-gray-500'>Aucune information trouvée</p>";
                        }
                    ?>
                    <!-- FIN DU PHP -->
                </div>
            </section>
            
            <!-- Formulaire de gestion des notes -->
            <section class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4 text-indigo-700">Gestion des notes</h2>
                
                <!-- PHP -->
                <?php
                    // Traitement du formulaire si soumis
                    if (isset($_POST['action'])) {
                        $email = $conn->real_escape_string($_POST['email']);
                        $filmTitle = $conn->real_escape_string($_POST['filmTitle']);
                        $action = $_POST['action'];
                        
                        if ($action === 'update' && isset($_POST['rating']) && isset($_POST['comment'])) {
                            $rating = intval($_POST['rating']);
                            $comment = $conn->real_escape_string($_POST['comment']);
                            
                            $updateQuery = "UPDATE NOTE n 
                                        JOIN CLIENT c ON n.codeClient = c.codeClient 
                                        JOIN FILM f ON n.codeFilm = f.codeFilm 
                                        SET n.note = {$rating}, 
                                            n.commentaire = '{$comment}', 
                                            n.dateNote = NOW() 
                                        WHERE c.courriel = '{$email}' 
                                        AND f.titre = '{$filmTitle}'";
                                        
                            if ($conn->query($updateQuery) === TRUE) {
                                echo "<div class='bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4'>
                                        Note mise à jour avec succès !
                                    </div>";
                            } else {
                                echo "<div class='bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4'>
                                        Erreur lors de la mise à jour: " . $conn->error . "
                                    </div>";
                            }
                        } elseif ($action === 'delete') {
                            $deleteQuery = "DELETE n FROM NOTE n 
                                        INNER JOIN CLIENT c ON n.codeClient = c.codeClient 
                                        INNER JOIN FILM f ON n.codeFilm = f.codeFilm 
                                        WHERE c.courriel = '{$email}' 
                                        AND f.titre = '{$filmTitle}'";
                                        
                            if ($conn->query($deleteQuery) === TRUE) {
                                echo "<div class='bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4'>
                                        Note supprimée avec succès !
                                    </div>";
                            } else {
                                echo "<div class='bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4'>
                                        Erreur lors de la suppression: " . $conn->error . "
                                    </div>";
                            }
                        }
                    }
                ?>
                <!-- FIN DU PHP -->
                
                <form method="post" class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email du client</label>
                        <input type="email" id="email" name="email" required 
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    
                    <div>
                        <label for="filmTitle" class="block text-sm font-medium text-gray-700">Titre du film</label>
                        <input type="text" id="filmTitle" name="filmTitle" required 
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex space-x-4">
                            <button type="button" onclick="showUpdateForm()" 
                                   class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Modifier une note
                            </button>
                            
                            <button type="submit" name="action" value="delete" 
                                   class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Supprimer une note
                            </button>
                        </div>
                    </div>
                    
                    <div id="updateForm" class="hidden space-y-4 border-t border-gray-200 pt-4">
                        <div>
                            <label for="rating" class="block text-sm font-medium text-gray-700">Nouvelle note (0-100)</label>
                            <input type="number" id="rating" name="rating" min="0" max="100" 
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        
                        <div>
                            <label for="comment" class="block text-sm font-medium text-gray-700">Nouveau commentaire</label>
                            <textarea id="comment" name="comment" rows="3" 
                                     class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        </div>
                        
                        <div>
                            <button type="submit" name="action" value="update" 
                                   class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </section>
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
        function showUpdateForm() {
            document.getElementById('updateForm').classList.remove('hidden');
        }
    </script>

    <!-- PHP -->
    <?php
        // Fermer la connexion
        $conn->close();
    ?>
    <!-- FIN DU PHP -->
</body>
</html>