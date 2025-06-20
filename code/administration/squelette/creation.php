<?php
require_once("../../ressources/includes/connexion-bdd.php");

$page_courante = "auteurs";

$formulaire_soumis = !empty($_POST);

if ($formulaire_soumis) {
    // On crée une nouvelle entrée
    $requete_brute = "
        INSERT INTO A-REMPLACER(...)
        VALUES (...)
    ";

    $resultat_brut = mysqli_query($mysqli_link, $requete_brute);

    if ($resultat_brut === true) {
        // Tout s'est bien passé
    } else {
        // Il y a eu un problème
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include_once("../ressources/includes/head.php"); ?>

    <title>Creation A-REMPLACER - Administration</title>
</head>

<body>
    <?php require_once('../ressources/includes/menu-principal.php'); ?>
    <header class="bg-white shadow">
        <div class="mx-auto max-w-7xl py-3 px-4">
            <p class="text-3xl font-bold text-gray-900">Créer</p>
        </div>
    </header>
    <main>
        <div class="mx-auto max-w-7xl py-6 px-4">
            <div class="py-6">
                <form method="POST" action="" class="rounded-lg bg-white p-4 shadow border-gray-300 border-1">
                    <section class="grid gap-6">
                        <div class="col-span-12">
                            <label for="nom" class="block text-lg font-medium text-gray-700">Nom</label>
                            <input type="text" name="nom" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus-within:border-indigo-500 focus-within:ring-indigo-500" id="prenom">
                        </div>
                        <div class="mb-3 col-md-6">
                            <button type="submit" class="rounded-md bg-indigo-600 py-2 px-4 text-lg font-medium text-white shadow-sm hover:bg-indigo-700 focus-within:bg-indigo-700">Créer</button>
                        </div>
                    </section>
                </form>
            </div>
        </div>
    </main>
    <?php require_once("../ressources/includes/global-footer.php"); ?>
</body>

</html>
