<?php
session_start();

require_once("../../vendor/autoload.php");
use App\Config\Database;

$db = new Database();
$conn = $db->connect();


$isLoggedIn = isset($_SESSION['users']) && $_SESSION['users']['role'] === 'Etudiant';
$userId = $isLoggedIn ? $_SESSION['users']['id'] : null;
if (isset($_POST['course_id']) && $isLoggedIn) {
    $courseId = $_POST['course_id'];
    $stmt = $conn->prepare("INSERT INTO inscription (etudiant_id, cours_id) VALUES (:etudiant_id, :cours_id)");
    $stmt->execute(['etudiant_id' => $userId, 'cours_id' => $courseId]);

    header('Location: users/etudiant/dashboard.php');
    exit(); // Assurez-vous de terminer l'exécution du script après la redirection
}

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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="style='z-index: 1 fixed w-full bg-white shadow">
        <div class="max-w-5xl mx-auto p-4 flex justify-between items-center">
            <a href="../../src/Views/index.php" class="text-2xl font-bold text-blue-600">Youdemy</a>
            <nav class="hidden md:flex gap-4">
                <a href="../Views/" class="hover:text-blue-600 mt-2">Accueil</a>
                <a href="#about" class="hover:text-blue-600 mt-2">À propos</a>
                <a href="#courses" class="hover:text-blue-600 mt-2">Cours</a>
                <a href="../Views/auth/Login.php" class="rounded-full overflow-hidden w-10 h-10">
                    <img src="../../Image/icon.webp" alt="Login" class="w-full h-full object-cover">
                </a>
            </nav>
            <button class="md:hidden">☰</button>
        </div>
    </header>

    <main>
        <section class="bg-blue-600 text-white pt-24 pb-12 text-center">
            <div class="max-w-3xl mx-auto px-4">
                <h2 class="text-3xl font-bold mb-4">Bienvenue à Youdemy</h2>
                <p>Libérez votre potentiel grâce à notre large éventail de cours dispensés par des experts.</p>
            </div>
        </section>

        <section id="about" class="py-12 bg-gray-50">
            <div class="max-w-3xl mx-auto px-4 text-center">
                <h2 class="text-2xl font-bold mb-4">YOU-DEMY</h2>
                <p class="mb-8">Youdemy est une plateforme à but non lucratif qui offre un accès gratuit à une éducation de qualité pour tous, partout dans le monde.</p>
                <img src="../../Image/image of home 2.jpg" alt="Learn online" class="w-full rounded shadow">
            </div>
        </section>

        <section id="courses" class="py-12 bg-white">
            <div class="max-w-6xl mx-auto px-4">
                <h2 class="text-2xl font-bold mb-8 text-center">Nos Cours Disponibles</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php if (!empty($cours)): ?>
                        <?php foreach ($cours as $cour): ?>
                            <div class="bg-white rounded-lg shadow-md flex flex-col">
                                <div class="relative w-full h-48">
                                    <?php if (!empty($cour['contenu'])): ?>
                                        <iframe id="video-<?php echo $cour['id']; ?>" src="<?php echo htmlspecialchars($cour['contenu']); ?>" frameborder="0" allowfullscreen class="w-full h-full hidden"></iframe>
                                        <img id="image-<?php echo $cour['id']; ?>" src="../../Image/inscription.png" alt="Default Image" class="w-full h-full">
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
                                    <?php if ($isLoggedIn): ?>
                                        <form method="POST" action="">
                                            <input type="hidden" name="course_id" value="<?php echo $cour['id']; ?>">
                                            <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded text-sm inline-block">S'inscrire</button>
                                        </form>
                                    <?php else: ?>
                                        <button onclick="redirectToLogin()" class="bg-blue-600 text-white py-2 px-4 rounded text-sm inline-block">S'inscrire</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-gray-500 text-center col-span-3">Aucun cours disponible pour le moment.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-white py-4 text-center text-gray-600">
        <p>Youdemy All Rights Reserved By Ayoub</p>
    </footer>

    <script>
        function redirectToLogin() {
            window.location.href = "../Views/auth/Login.php";
        }

        function showVideo(courseId) {
            const video = document.getElementById(`video-${courseId}`);
            const image = document.getElementById(`image-${courseId}`);

            if (video && image) {
                video.style.display = 'block';
                image.style.display = 'none';
            }
        }

        const isLoggedIn = <?php echo $isLoggedIn ? 'true' : 'false'; ?>;
        if (isLoggedIn) {
            document.querySelectorAll('.bg-blue-600').forEach(button => {
                button.onclick = function() {
                    const courseId = this.getAttribute('data-course-id');
                    showVideo(courseId);
                };
            });
        }
    </script>
</body>
</html>