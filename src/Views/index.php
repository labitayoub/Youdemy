<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<header class="fixed w-full bg-white shadow">
    <div class="max-w-5xl mx-auto p-4 flex justify-between items-center">
    <a href="../../src/Views/index.php" class="text-2xl font-bold text-blue-600">Youdemy</a>
    <nav class="hidden md:flex gap-4">
            <a href="../Views/" class="hover:text-blue-600">Home</a>
            <a href="#about" class="hover:text-blue-600">About</a>
            <a href="#courses" class="hover:text-blue-600">Courses</a>
            <a href="../Views/auth/Login.php" class="border border-blue-600 text-blue-600 px-4 py-2 rounded">Login</a>
            <a href="../Views/auth/Register.php" class="bg-blue-600 text-white px-4 py-2 rounded">Sign Up</a>
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
</main>

<footer class="bg-white py-4 text-center text-gray-600">
    <p>Youdemy All Rights Reserved By Ayoub</p>
</footer>
</body>
</html>