<?php
require_once "../../ressources/includes/connexion-bdd.php";

$page_courante = "auteurs";

$errors = [];
$formulaire_soumis = !empty($_POST);

$nom = $_POST['nom'] ?? '';
$prenom = $_POST['prenom'] ?? '';
$lien_avatar = $_POST['lien_avatar'] ?? '';
$lien_twitter = $_POST['lien_twitter'] ?? '';

if ($formulaire_soumis) {
    // Validation des champs requis
    if (empty(trim($nom))) {
        $errors['nom'] = "Le nom est requis.";
    }
    if (empty(trim($prenom))) {
        $errors['prenom'] = "Le prénom est requis.";
    }
    if (empty(trim($lien_avatar))) {
        $errors['lien_avatar'] = "Le lien de l'avatar est requis.";
    } elseif (!filter_var($lien_avatar, FILTER_VALIDATE_URL)) {
        $errors['lien_avatar'] = "Le lien de l'avatar doit être une URL valide.";
    }
    if (!empty(trim($lien_twitter)) && !filter_var($lien_twitter, FILTER_VALIDATE_URL)) {
        $errors['lien_twitter'] = "Le lien Twitter doit être une URL valide.";
    }

    // Si aucun champ n'a d'erreur, on procède à l'insertion
    if (empty ($errors)) {
        $nom = htmlentities($_POST["nom"]);
        $prenom = htmlentities($_POST["prenom"]);
        $lien_avatar = htmlentities($_POST["lien_avatar"]);
        $lien_twitter = htmlentities($_POST["lien_twitter"]);

        $requete_brute = "
            INSERT INTO auteur(prenom, nom, lien_avatar, lien_twitter)
            VALUES ('$nom', '$prenom', '$lien_avatar', '$lien_twitter')
        ";
        $resultat_brut = mysqli_query($mysqli_link, $requete_brute);

        if ($resultat_brut === true) {
            // Tout s'est bien passé, l'utilisateur retourne à la liste des auteurs
            $racineURL = pathinfo($_SERVER['REQUEST_URI']);
            $pageRedirection = $racineURL['dirname'];
            header("Location: $pageRedirection");
        } else {
            // Il y a eu un problème
            $errors['global'] = "Une erreur s'est produite lors de la création de l'auteur.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once('../ressources/includes/head.php'); ?>

    <title>Creation auteur - Administration</title>

    <link rel="stylesheet" href="./administration/ressources/css/adm-form.css">
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
                <?php if (!empty($errors)): ?>
                    <section class="banniere-erreur" role="alert" aria-live="polite">
                        <p>Veuillez indiquer les champs requis.</p>
                    </section>
                <?php endif; ?>
                <form method="POST" action="" class="rounded-lg bg-white p-4 shadow border-gray-300 border-1">
                    <section class="grid gap-6">
                        <div class="col-span-12">
                            <label for="nom" class="block text-lg font-medium text-gray-700">Nom</label>
                            <input type="text" name="nom" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" id="nom" value="<?= htmlspecialchars($nom) ?>">
                            <?php if (!empty($errors['nom'])): ?>
                                <span class="text-red-600 mt-2"><?= $errors['nom'] ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="col-span-12">
                            <label for="prenom" class="block text-lg font-medium text-gray-700">Prénom</label>
                            <input type="text" name="prenom" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus-within:border-indigo-500 focus-within:ring-indigo-500" id="prenom" value="<?= htmlspecialchars($prenom) ?>">
                            <?php if (!empty($errors['prenom'])): ?>
                                <span class="text-red-600 mt-2"><?= $errors['prenom'] ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="col-span-12">
                            <label for="avatar" class="block text-lg font-medium text-gray-700">Lien avatar</label>
                            <input type="url" name="lien_avatar" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus-within:border-indigo-500 focus-within:ring-indigo-500" id="avatar" value="<?= htmlspecialchars($lien_avatar) ?>">
                            <p class="text-sm text-gray-500">
                                Mettre l'URL de l'avatar (chemin absolu)
                            </p>
                            <?php if (!empty($errors['lien_avatar'])): ?>
                                <span class="text-red-600 mt-2"><?= $errors['lien_avatar'] ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="col-span-12">
                            <label for="lien_twitter" class="block text-lg font-medium text-gray-700">Lien twitter</label>
                            <input type="url" name="lien_twitter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus-within:border-indigo-500 focus-within:ring-indigo-500" id="lien_twitter" value="<?= htmlspecialchars($lien_twitter) ?>">
                            <?php if (!empty($errors['lien_twitter'])): ?>
                                <span class="text-red-600 mt-2"><?= $errors['lien_twitter'] ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3 col-md-6">
                            <button type="submit" class="font-medium rounded-md bg-indigo-600 py-2 px-4 text-lg text-white shadow-sm hover:bg-indigo-700 focus-within:bg-indigo-700">Créer</button>
                        </div>
                    </section>
                </form>
            </div>
        </div>
    </main>
    <?php require_once("../ressources/includes/global-footer.php"); ?>
</body>
</html>
