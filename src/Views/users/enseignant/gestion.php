<?php
session_start();

if (!isset($_SESSION['users'])) {
    header('Location: ../../../../auth/Login.php');
    exit();
}

require_once("../../../../vendor/autoload.php");
use App\Config\Database;

$db = new Database();
$conn = $db->connect();

$userId = $_SESSION['users']['id']; // Ensure this matches how the user ID is stored in the session

$totalEtudiants = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'Etudiant'")->fetchColumn();
$totalEnseignants = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'Enseignant'")->fetchColumn();
$totalCours = $conn->query("SELECT COUNT(*) FROM cours")->fetchColumn();

try {
    $query = "
        SELECT cours.id, cours.titre, cours.description, categorie.nom AS categorie, 
               GROUP_CONCAT(tag.nom SEPARATOR ', ') AS tags, 
               CONCAT(users.nom, ' ', users.prenom) AS enseignant
        FROM cours
        JOIN categorie ON cours.categorie_id = categorie.id
        LEFT JOIN coursTag ON cours.id = coursTag.cours_id
        LEFT JOIN tag ON coursTag.tag_id = tag.id
        JOIN users ON cours.user_id = users.id
        WHERE cours.user_id = :userId
        GROUP BY cours.id
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute([':userId' => $userId]);
    $cours = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur lors de la récupération des cours: " . $e->getMessage());
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouDemy Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            height: 64px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .sidebar {
            position: fixed;
            top: 64px;
            left: 0;
            bottom: 0;
            width: 256px;
            z-index: 999;
            background-color: #1f2937;
            color: white;
        }
        .main-content {
            margin-top: 64px;
            margin-left: 256px;
            padding: 1rem;
        }
    </style>
</head>
<body class="bg-gray-100">
    <header class="navbar">
        <div class="max-w-full mx-auto px-4 py-3 flex justify-between items-center">
            <a href="../../Views/index.php" class="text-2xl font-bold text-blue-600">Youdemy</a>
            <nav class="hidden md:flex items-center gap-6">
                <a href="../../index.php" class="hover:text-blue-600">Accueil</a>
                <a href="../../index.php" class="hover:text-blue-600">À propos</a>
                <a href="../../cours.php" class="hover:text-blue-600">Cours</a>
                <a href="#admin" class="hover:text-blue-600">
                    <i class="fas fa-user-circle"></i>
                    <span class="ml-2">Admin</span>
                </a>
                <a href="../../auth/logout.php" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                    Déconnexion
                </a>
            </nav>
            <label for="mobile-menu" class="md:hidden cursor-pointer">
                <i class="fas fa-bars text-2xl"></i>
            </label>
        </div>
    </header>

    <aside class="sidebar">
        <nav class="mt-5 px-2">
            <a href="dashboard.php" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 rounded-md">
                <i class="fas fa-home mr-3"></i> Tableau de bord
            </a>
            <a href="creation.php" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 rounded-md">
                <i class="fas fa-chalkboard-teacher mr-3"></i> Creation
            </a>
            <a href="Gestion.php" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 rounded-md">
                <i class="fas fa-user-graduate mr-3"></i> Gestion
            </a>
        </nav>
    </aside>

    <div class="main-content">
        <h2 class="text-2xl font-bold mb-6 mt-11">Statistique Globale</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-gray-500 text-sm"> Total des Etudiants</h4>
                        <h3 class="text-2xl font-bold"><?php echo $totalEtudiants ?></h3>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                        <i class="fas fa-book text-2xl"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-gray-500 text-sm">Total des Cours </h4>
                        <h3 class="text-2xl font-bold"><?php echo $totalCours ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Liste des Cours</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 tracking-wider">Titre</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 tracking-wider">Categorie</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 tracking-wider">Tags</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 tracking-wider">Enseignant</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 tracking-wider">Update</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 tracking-wider">Delete</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
    <?php if (count($cours) > 0): ?>
        <?php foreach ($cours as $cour): ?>
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($cour['titre']); ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($cour['description']); ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($cour['categorie']); ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($cour['tags']); ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($cour['enseignant']); ?></td>
                <td>
                    <a href="../enseignant/update.php?id=<?php echo $cour['id']; ?>" class="bg-blue-500 text-white px-2 py-2 rounded">Modifier</a>
                </td>
                <td>
                    <a href="../enseignant/delete.php?id=<?php echo $cour['id']; ?>" class="bg-red-500 text-white px-2 py-2 rounded">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Aucun cours trouvé</td>
        </tr>
    <?php endif; ?>
</tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>