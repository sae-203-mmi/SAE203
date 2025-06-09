<?php
require_once '../../ressources/includes/connexion-bdd.php';

$page_courante = 'auteurs';

$errors = [];
$formulaire_soumis = !empty($_POST);
$id_present_url = array_key_exists('id', $_GET);

$entite = null;
if ($id_present_url) {
    $id = $_GET["id"];
    $requete_brute = "SELECT * FROM auteur WHERE id = $id";
    $resultat_brut = mysqli_query($mysqli_link, $requete_brute);
    $entite = mysqli_fetch_array($resultat_brut, MYSQLI_ASSOC);
}

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
    // Si aucun champ n'a d'erreur, on procède à l'édition
    if (empty($errors)) {
        $id = $_POST["id"];
        $nom = htmlentities($_POST["nom"]);
        $prenom = htmlentities($_POST["prenom"]);
        $lien_avatar = htmlentities($_POST["lien_avatar"]);
        $lien_twitter = htmlentities($_POST["lien_twitter"]);

        $requete_brute = "
            UPDATE auteur
            SET
                nom = '$nom',
                prenom = '$prenom',
                lien_avatar ='$lien_avatar',
                lien_twitter = '$lien_twitter'
            WHERE id = '$id'
        ";

        $resultat_brut = mysqli_query($mysqli_link, $requete_brute);

        if ($resultat_brut === true) {
            $racineURL = pathinfo($_SERVER['REQUEST_URI']);
            $pageRedirection = $racineURL['dirname'];
            header("Location: $pageRedirection");
            // Tout s'est bien passé, l'utilisateur retourne à la liste des auteurs
        } else {
            // Il y a eu un problème
            $errors['global'] = "Une erreur s'est produite lors de l'édition de l'auteur.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include_once '../ressources/includes/head.php'; ?>

    <title>Editeur auteur - Administration</title>
    <link rel="stylesheet" href="./administration/ressources/css/adm-form.css">
</head>

<body>
    <?php include_once '../ressources/includes/menu-principal.php'; ?>
    <header style="view-transition-name: auteur-<?php echo $id; ?>"  class="bg-white shadow">
        <div class="mx-auto max-w-7xl py-3 px-4">
            <p class="text-3xl font-bold text-gray-900">Editer
                "<?php echo $entite['nom']; ?> <?php echo $entite['prenom']; ?>"
            </p>
        </div>
    </header>
    <main>
        <div class="mx-auto max-w-7xl py-6 px-4">
            <div class="py-6">
                <?php if ($entite) { ?>
                    <?php if (!empty($errors)): ?>
                    <section class="banniere-erreur" role="alert" aria-live="polite">
                        <p>Veuillez indiquer les champs requis.</p>
                    </section>
                <?php endif; ?>
                    <form method="POST" action="" class="rounded-lg bg-white p-4 shadow border-gray-300 border-1">
                        <section class="grid gap-6">
                            <input type="hidden" value="<?php echo $entite[
                                'id'
                            ]; ?>" name="id">
                            <div class="col-span-12">
                                <label for="nom" class="block text-lg font-medium text-gray-700">Nom</label>
                                <input type="text" value="<?= htmlspecialchars($formulaire_soumis ? $nom : $entite['nom']) ?>" name="nom" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" id="nom">   
                                <?php if (!empty($errors['nom'])): ?>
                                    <span class="text-red-600 mt-2"><?= $errors['nom'] ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="col-span-12">
                                <label for="prenom" class="block text-lg font-medium text-gray-700">Prénom</label>
                                <input type="text" value="<?= htmlspecialchars($formulaire_soumis ? $prenom : $entite['prenom']) ?>" name="prenom" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" id="prenom">
                                <?php if (!empty($errors['prenom'])): ?>
                                    <span class="text-red-600 mt-2"><?= $errors['prenom'] ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="col-span-12">
                                <label for="avatar" class="block text-lg font-medium text-gray-700">Lien avatar</label>
                                <input type="url" value="<?= htmlspecialchars($formulaire_soumis ? $lien_avatar : $entite['lien_avatar']) ?>" name="lien_avatar" class="block w-full rounded-md border-gray-300 shadow-sm focus-within:border-indigo-500 focus-within:ring-indigo-500" id="avatar">
                                <p class="text-sm text-gray-500">
                                    Mettre l'URL de l'avatar (chemin absolu)
                                </p>
                                <?php if (!empty($errors['lien_avatar'])): ?>
                                    <span class="text-red-600 mt-2"><?= $errors['lien_avatar'] ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="col-span-12">
                                <label for="lien_twitter" class="block text-lg font-medium text-gray-700">Lien twitter</label>
                                <input type="url" value="<?= htmlspecialchars($formulaire_soumis ? $lien_twitter : $entite['lien_twitter']) ?>" name="lien_twitter" class="block w-full rounded-md border-gray-300 shadow-sm focus-within:border-indigo-500 focus-within:ring-indigo-500" id="lien_twitter">
                                <?php if (!empty($errors['lien_twitter'])): ?>
                                    <span class="text-red-600 mt-2"><?= $errors['lien_twitter'] ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3 col-md-6">
                                <button type="submit" class="rounded-md bg-indigo-600 py-2 px-4 text-lg font-medium text-white shadow-sm hover:bg-indigo-700 focus-within:bg-indigo-700">Éditer</button>
                            </div>
                        </section>
                    </form>
                <?php } else { ?>
                    <section class="banniere-erreur" role="alert" aria-live="polite">
                        <p>Auteur introuvable.</p>
                    </section>
                <?php } ?>
            </div>
        </div>
    </main>
    <?php require_once("../ressources/includes/global-footer.php"); ?>
</body>
</html>
