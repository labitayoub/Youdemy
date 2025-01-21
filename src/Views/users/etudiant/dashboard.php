<?php
session_start();

if (!isset($_SESSION['users'])) {
    header('Location: ../../auth/Login.php');
    exit();
}

require_once("../../../../vendor/autoload.php");

use App\Config\Database;

$db = new Database();
$conn = $db->connect();

$totalEtudiants = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'Etudiant'")->fetchColumn();
$totalEnseignants = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'Enseignant'")->fetchColumn();
$totalCours = $conn->query("SELECT COUNT(*) FROM cours")->fetchColumn();

$cours = $conn->query("
    SELECT cours.id, cours.titre, cours.contenu, cours.description, 
           categorie.nom AS categorie, 
           GROUP_CONCAT(tag.nom SEPARATOR ', ') AS tags, 
           CONCAT(users.nom, ' ', users.prenom) AS enseignant
    FROM cours
    JOIN categorie ON cours.categorie_id = categorie.id
    LEFT JOIN coursTag ON cours.id = coursTag.cours_id
    LEFT JOIN tag ON coursTag.tag_id = tag.id
    JOIN users ON cours.user_id = users.id
    GROUP BY cours.id
")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouDemy Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <header class="fixed w-full bg-white shadow z-50">
        <div class="max-w-5xl mx-auto p-4 flex justify-between items-center">
            <a href="../../Views/index.php" class="text-2xl font-bold text-blue-600">Youdemy</a>
            <nav class="hidden md:flex gap-4">
                <a href="../../index.php" class="hover:text-blue-600">Accueil</a>
                <a href="#about" class="hover:text-blue-600">À propos</a>
                <a href="#courses" class="hover:text-blue-600">Cours</a>
                <a href="#admin" class="hover:text-blue-600"><i class="fas fa-user-circle text-xl"></i> Admin</a>
                <a href="../../auth/logout.php" class="bg-red-600 text-white px-4 py-2 rounded">Logout</a>
                </nav>
            <button class="md:hidden">☰</button>
        </div>
    </header>

    <div class="fixed inset-y-0 mt-12 left-0 w-64 bg-gray-900 text-white z-40">
        <nav class="mt-5 px-2">
            <a href="dashboard.php" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 rounded-md">
                <i class="fas fa-home mr-3"></i> Tableau de bord
            </a>
        </nav>
    </div>



        <h2 class="text-2xl font-semibold mb-6">Mes Cours</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (!empty($cours)): ?>
                <?php foreach ($cours as $cour): ?>
                    <div class="bg-white rounded-lg shadow-md flex flex-col">
                        <div class="relative w-full h-48">
                            <?php if (!empty($cour['contenu'])): ?>
                                <iframe src="<?php echo htmlspecialchars($cour['contenu']); ?>" frameborder="0" allowfullscreen class="w-full h-full"></iframe>
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center bg-gray-300 text-gray-500">Pas de vidéo</div>
                            <?php endif; ?>
                        </div>
                        <div class="p-4 flex-1">
                            <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($cour['titre']); ?></h3>
                            <p class="text-sm text-gray-500"><?php echo htmlspecialchars($cour['enseignant']); ?> | Catégorie: <?php echo htmlspecialchars($cour['categorie']); ?></p>
                            <p class="text-gray-600 mt-2 line-clamp-3"><?php echo htmlspecialchars($cour['description']); ?></p>
                        </div>
                        <div class="px-4 pb-4">
                            <p class="text-sm text-gray-500">Tags: <?php echo htmlspecialchars($cour['tags']); ?></p>
                        </div>
                        <div class="px-4 py-4 bg-gray-50">
                        <a href="supprimer.php?id=<?php echo $cour['id']; ?>" onclick="return confirm('Supprimer ce cours ?');" class="bg-red-500 text-white py-2 px-4 rounded text-sm">Supprimer</a></div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-500 text-center col-span-3">Aucun cours disponible.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>