<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Simplifié</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 text-gray-700">
    
    <aside class="fixed top-0 left-0 h-screen w-56 bg-blue-600 text-white p-4">
        <h1 class="text-lg font-bold mb-6">Mon Dashboard</h1>
        <nav class="space-y-4">
            <a href="#" class="block p-2 rounded-lg hover:bg-blue-700">Tableau de bord</a>
            <a href="#" class="block p-2 rounded-lg hover:bg-blue-700">Offres</a>
            <a href="#" class="block p-2 rounded-lg hover:bg-blue-700">Candidatures</a>
            <a href="#" class="block p-2 rounded-lg hover:bg-blue-700">Profil</a>
            <a href="#" class="block p-2 rounded-lg hover:bg-blue-700">Paramètres</a>
        </nav>
    </aside>

    <main class="ml-56 p-6">
        <h2 class="text-2xl font-semibold mb-4">Bienvenue, Jean</h2>
        <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white shadow rounded-lg p-4">
                <h3 class="text-lg font-semibold mb-2">Statistiques</h3>
                <p>Nombre de candidatures : <span class="text-blue-600 font-bold">12</span></p>
                <p>Entretiens planifiés : <span class="text-blue-600 font-bold">3</span></p>
            </div>

            <div class="bg-white shadow rounded-lg p-4">
                <h3 class="text-lg font-semibold mb-2">Actions rapides</h3>
                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Télécharger mon CV</button>
                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 mt-2">Mettre à jour le profil</button>
            </div>
        </section>
    </main>
</body>
</html>