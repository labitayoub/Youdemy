<?php
session_start();

if (!isset($_SESSION['users'])) {
    header('Location: ../../../../auth/Login.php');
    exit();
}

require_once("../../../../vendor/autoload.php");
use App\Controllers\CoursController;
use App\Config\Database;

$db = new Database();
$conn = $db->connect();

$categories = $conn->query("SELECT id, nom FROM categorie ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
$tags = $conn->query("SELECT id, nom FROM tag ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user_id = $_SESSION['users']['id'];

    $coursController = new CoursController();
    $course = $coursController->getCoursById($id);

    if (!$course) {
        echo "Cours non trouvé.";
        exit();
    }


}

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $contenu = $_POST['contenu_course'];
    $categorie_id = $_POST['categorie_id'];
    $user_id = $_SESSION['users']['id'];
    $selectedTags = isset($_POST['tags']) ? $_POST['tags'] : [];

    $coursController = new CoursController();
    $result = $coursController->mettreAJourCours($id, $titre, $description, $contenu, $categorie_id, $user_id, $selectedTags);

    if ($result) {
        header('Location: gestion.php');
        exit();
    } else {
        echo "Erreur lors de la mise à jour du cours.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouDemy Admin - Mise à jour de cours</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="main-content">
        <div class="container mx-auto px-4">
            <div class="flex justify-center">
                <div class="w-full max-w-2xl">
                    <div class="bg-white rounded-lg shadow-2xl">
                        <div class="bg-blue-600 text-center p-8 rounded-t-lg">
                            <div class="text-white text-2xl font-bold mb-2">
                                <i class="fas fa-book-open me-2"></i>Youdemy
                            </div>
                            <h4 class="text-white font-bold text-xl">Mettre à jour un cours</h4>
                        </div>

                        <div class="p-8">
                            <form method="POST" class="space-y-6">
                                <input type="hidden" name="id" value="<?= $course['id'] ?>">
                                <div>
                                    <label class="block text-blue-600 font-medium mb-2">Titre du cours</label>
                                    <input type="text" name="titre" value="<?= htmlspecialchars($course['titre']) ?>" class="w-full p-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" placeholder="Titre du cours" required>
                                </div>

                                <div>
                                    <label class="block text-blue-600 font-medium mb-2">Description</label>
                                    <textarea name="description" class="w-full p-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" placeholder="Description du cours" rows="4" required><?= htmlspecialchars($course['description']) ?></textarea>
                                </div>

                                <div>
                                    <label class="block text-blue-600 font-medium mb-2">URL de la vidéo du cours</label>
                                    <input type="url" name="contenu_course" value="<?= htmlspecialchars($course['contenu']) ?>" class="w-full p-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" placeholder="Entrer le lien url (Youtube)" required>
                                </div>

                                <div>
                                    <label class="block text-blue-600 font-medium mb-2">Catégorie</label>
                                    <select name="categorie_id" class="w-full p-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" required>
                                        <option value="">Choisir la catégorie</option>
                                        <?php foreach ($categories as $categorie): ?>
                                            <option value="<?= htmlspecialchars($categorie['id']) ?>" <?= $categorie['id'] == $course['categorie_id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($categorie['nom']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-blue-600 font-medium mb-2">Tags</label>
                                    <div class="tag-container">
                                        <?php foreach ($tags as $tag): ?>
                                            <label class="tag-checkbox">
                                                <input type="checkbox" name="tags[]" value="<?= htmlspecialchars($tag['id']) ?>" <?= in_array($tag['id'], $course['tags']) ? 'checked' : '' ?>>
                                                <span class="tag-label"><?= htmlspecialchars($tag['nom']) ?></span>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <button type="submit" name="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-md transition duration-300 hover:bg-blue-700">
                                    Mettre à jour le cours
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>