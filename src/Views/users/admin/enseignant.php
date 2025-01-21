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

$users = $conn->query("SELECT * FROM Users WHERE role = 'Enseignant'")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $nouveau_statut = $_POST['status'];

    $update_sql = "UPDATE users SET compte_statut = :compte_statut WHERE id = :user_id";
    $params = [
        'compte_statut' => $nouveau_statut,
        'user_id' => $user_id
    ];

    try {
        $stmt = $conn->prepare($update_sql);
        $stmt->execute($params);
        header("Location:../admin/enseignant.php");
        exit();
    } catch (Exception $e) {
        echo "Erreur lors de la mise à jour du statut: " . $e->getMessage();
    }
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
    <!-- Navbar -->
    <header class="navbar">
        <div class="max-w-full mx-auto px-4 py-3 flex justify-between items-center">
            <!-- Logo -->
            <a href="../../Views/index.php" class="text-2xl font-bold text-blue-600">Youdemy</a>

            <nav class="hidden md:flex items-center gap-6">
                <a href="../../index.php" class="hover:text-blue-600">Accueil</a>
                <a href="#about" class="hover:text-blue-600">À propos</a>
                <a href="#courses" class="hover:text-blue-600">Cours</a>
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
            <a href="Enseignant.php" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 rounded-md">
                <i class="fas fa-chalkboard-teacher mr-3"></i> Enseignants
            </a>
            <a href="Etudiant.php" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 rounded-md">
                <i class="fas fa-user-graduate mr-3"></i> Étudiants
            </a>
            <a href="categories.php" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 rounded-md">
                <i class="fas fa-folder mr-3"></i> Catégories
            </a>
            <a href="tags.php" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 rounded-md">
                <i class="fas fa-tags mr-3"></i> Tags
            </a>
            <a href="supprimer.php" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 rounded-md">
                <i class="fas fa-trash mr-3"></i> Supprimer
            </a>
        </nav>
    </aside>

    <div class="main-content">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Liste des Enseignants</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 tracking-wider">Nom</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 tracking-wider">Prenom</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (count($users) > 0): ?>
                        <?php foreach ($users as $user): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($user['nom']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($user['prenom']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($user['email']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($user['role']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($user['compte_statut']); ?></td>
                                <td class="py-3 px-4">
                                    <form method="POST" action="" class="inline-block">
                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                        <select name="status" class="bg-indigo-600 text-white py-2 px-4 rounded-md">
                                            <option value="Actif" <?php echo $user['compte_statut'] === 'Actif' ? 'selected' : ''; ?>>Actif</option>
                                            <option value="Suspendu" <?php echo $user['compte_statut'] === 'Suspendu' ? 'selected' : ''; ?>>Suspendu</option>
                                            <option value="Non Actif" <?php echo $user['compte_statut'] === 'Non Actif' ? 'selected' : ''; ?>>Non Actif</option>
                                        </select>
                                        <button type="submit" class="ml-2 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700" onclick="return confirm('Êtes-vous sûr de vouloir mettre à jour le statut de cet utilisateur ?');">
                                            Update
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Aucun utilisateur trouvé</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>