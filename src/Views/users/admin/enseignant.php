<?php
require_once("../../../../vendor/autoload.php");

use App\Config\Database;
use App\Controllers\UserController;

$db = new Database();
$conn = $db->connect();




if (isset($_POST['user_id'], $_POST['nouveau_statut'])) {
    $userId = $_POST['user_id'];
    $nouveau_statut = $_POST['nouveau_statut'];
    $userController->updateUserStatus($userId, $nouveau_statut);

        $userController = new UserController();
        $userController->updateUserStatus($nom, $prenom, $email, $password, $role);
   
}

$users = $conn->query("SELECT * FROM Users where role = 'Enseignant'")->fetchAll(PDO::FETCH_ASSOC);
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
            </nav>
            <button class="md:hidden">☰</button>
        </div>
    </header>

    <div class="fixed inset-y-0 mt-12 left-0 w-64 bg-gray-900 text-white z-40">

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
        </nav>
    </div>

    <div class="md:pl-64 flex flex-col flex-1">
        <main class="flex-1 pt-24 pb-6 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">
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
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo ($user['nom']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo ($user['prenom']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo ($user['email']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo ($user['role']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo ($user['compte_statut']); ?></td>
                                        <td>
                                        <form method="POST" action="">
                                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                                <select name="nouveau_statut" class="compte_statut-status" id="compte_statut" onchange="submitStatus(this)">
                                                    <option value="Activated" data-color="green" <?php if ($user['compte_statut'] == 'Activated') echo 'selected'; ?>>Actif</option>
                                                    <option value="Not Activated" data-color="orange" <?php if ($user['compte_statut'] == 'Not Activated') echo 'selected'; ?>>Not Activated</option>
                                                    <option value="Suspended" data-color="red" <?php if ($user['compte_statut'] == 'Suspended') echo 'selected'; ?>>Suspended</option>
                                                    <option value="Deleted" data-color="gray" <?php if ($user['compte_statut'] == 'Deleted') echo 'selected'; ?>>Deleted</option>
                                                </select>
                                            </form>
                                            <form method="POST" action="">
                                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                                <button type="submit" name="delete_user" class="text-red-600 hover:text-red-900">Supprimer</button>
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
        </main>
    </div>


</body>

</html>