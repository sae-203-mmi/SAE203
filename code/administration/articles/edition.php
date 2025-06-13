<?php
require_once('../../ressources/includes/connexion-bdd.php');

$page_courante = "articles";

$errors = [];
$formulaire_soumis = !empty($_POST);
$id_present_url = array_key_exists("id", $_GET);

$entite = null;
if ($id_present_url) {
    $id = $_GET["id"];
    // On cherche l'article à éditer
    $requete_brute = "SELECT * FROM article WHERE id = $id";
    $resultat_brut = mysqli_query($mysqli_link, $requete_brute);
    $entite = mysqli_fetch_array($resultat_brut, MYSQLI_ASSOC);
}

$auteurs = [];
$result = mysqli_query($mysqli_link, "SELECT id, nom, prenom FROM auteur");
while ($row = mysqli_fetch_assoc($result)) {
    $auteurs[] = $row;
}

$titre = $_POST['titre'] ?? '';
$chapo = $_POST['chapo'] ?? '';
$contenu = $_POST['contenu'] ?? '';
$image = $_POST['image'] ?? '';
$auteur_id = $_POST['auteur_id'] ?? null;
$lien_yt = $_POST['lien_yt'] ?? '';

if ($formulaire_soumis) {
    // Validation des champs requis
    if (empty(trim($titre))) {
        $errors['titre'] = "Le titre est requis.";
    }
    if (empty(trim($chapo))) {
        $errors['chapo'] = "Le chapô est requis.";
    }
    if (empty(trim($contenu))) {
        $errors['contenu'] = "Le contenu est requis.";
    }
    if (empty(trim($image))) {
        $errors['image'] = "L'image est requise.";
    } elseif (!filter_var($image, FILTER_VALIDATE_URL)) {
        $errors['image'] = "L'image doit être une URL valide.";
    }
     if (!empty(trim($lien_yt)) && !filter_var($lien_yt, FILTER_VALIDATE_URL)) {
        $errors['lien_yt'] = "Le lien YouTube doit être une URL valide.";
    }

    // Si aucun champ n'a d'erreur, on procède à l'insertion
    if (empty ($errors)) {
        $id = $_POST["id"];
        $titre = htmlentities($_POST["titre"]);
        $chapo = htmlentities($_POST["chapo"]);
            $contenu = htmlentities($_POST["contenu"]);
            $image = htmlentities($_POST["image"]);
            $lien_yt = htmlentities($_POST["lien_yt"]);
        // On crée notre requête pour éditer une entité
        $requete_brute = "
            UPDATE article
            SET
                titre = '$titre',
                chapo = '$chapo',
                contenu = '$contenu',
                image = '$image',
                auteur_id = '$auteur_id',
                lien_yt ='$lien_yt'

            WHERE id = '$id'
        ";
        // On met à jour l'élément
        $resultat_brut = mysqli_query($mysqli_link, $requete_brute);
            if ($resultat_brut === true) {
                // Tout s'est bien passé, l'utilisateur retourne à la liste des articles
                $racineURL = pathinfo($_SERVER['REQUEST_URI']);
                $pageRedirection = $racineURL['dirname'];
                header("Location: $pageRedirection");
            } else {
                // Il y a eu un problème
                $errors['global'] = "Une erreur s'est produite lors de l'édition de l'article.";
            }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include_once("../ressources/includes/head.php"); ?>

    <title>Editer Articles - Administration</title>
</head>

<body>
<?php include_once '../ressources/includes/menu-principal.php'; ?>
    <header style="view-transition-name: article-<?php echo $id; ?>" class="bg-white shadow">
        <div class="mx-auto max-w-7xl py-3 px-4">
            <p class="text-3xl font-bold text-gray-900">Editer "<?php echo $entite['titre']; ?>"</p>
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
                            <label for="titre" class="block text-lg font-medium text-gray-700">Titre</label>
                            <input type="text" name="titre"  value="<?= htmlspecialchars($formulaire_soumis ? $titre : $entite['titre']) ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus-within:border-indigo-500 focus-within:ring-indigo-500" id="titre">
                            <?php if (!empty($errors['titre'])): ?>
                                <span class="text-red-600 mt-2"><?= $errors['titre'] ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="col-span-12">
                            <label for="chapo" class="block text-lg font-medium text-gray-700">Chapô</label>
                            <textarea type="text" name="chapo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus-within:border-indigo-500 focus-within:ring-indigo-500" id="chapo"><?= htmlspecialchars($formulaire_soumis ? $chapo : $entite['chapo']) ?></textarea>
                            <?php if (!empty($errors['chapo'])): ?>
                                <span class="text-red-600 mt-2"><?= $errors['chapo'] ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="col-span-12">
                            <label for="contenu" class="block text-lg font-medium text-gray-700">Contenu</label>
                            <textarea type="text" name="contenu" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus-within:border-indigo-500 focus-within:ring-indigo-500" id="contenu"><?= htmlspecialchars($formulaire_soumis ? $contenu : $entite['contenu']) ?></textarea>
                            <?php if (!empty($errors['contenu'])): ?>
                                <span class="text-red-600 mt-2"><?= $errors['contenu'] ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="col-span-12">
                            <label for="image" class="block text-lg font-medium text-gray-700">Image</label>
                            <input type="url" name="image" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus-within:border-indigo-500 focus-within:ring-indigo-500" id="image" value="<?= htmlspecialchars($formulaire_soumis ? $image : $entite['image']) ?>">
                            <p class="text-sm text-gray-500">
                                Mettre l'URL de l'image (chemin absolu)
                            </p>
                            <?php if (!empty($errors['image'])): ?>
                                <span class="text-red-600 mt-2"><?= $errors['image'] ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="col-span-12">
                            <label for="auteur_id" class="block text-lg font-medium text-gray-700">Auteur</label>
                            <select name="auteur_id" id="auteur_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus-within:border-indigo-500 focus-within:ring-indigo-500">
                                <?php foreach ($auteurs as $auteur): ?>
                                    <option value="<?= $auteur['id'] ?>" <?= ($formulaire_soumis ? $auteur_id : $entite['auteur_id']) == $auteur['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($auteur['nom'] . ' ' . $auteur['prenom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-span-12">
                            <label for="lien_yt" class="block text-lg font-medium text-gray-700">Lien YouTube</label>
                            <input type="url" name="lien_yt" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus-within:border-indigo-500 focus-within:ring-indigo-500" id="lien_yt" value="<?= htmlspecialchars($formulaire_soumis ? $lien_yt : $entite['lien_yt']) ?>">
                            <?php if (!empty($errors['lien_yt'])): ?>
                                <span class="text-red-600 mt-2"><?= $errors['lien_yt'] ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3 col-md-6">
                            <button type="submit" class="rounded-md bg-indigo-600 py-2 px-4 text-lg font-medium text-white shadow-sm hover:bg-indigo-700 focus-within:bg-indigo-700">Editer</button>
                        </div>
                    </section>
                </form>
                <?php } else { ?>
                    <section class="banniere-erreur" role="alert" aria-live="polite">
                        <p>Article introuvable.</p>
                    </section>
                <?php } ?>
            </div>
        </div>
    </main>
    <?php require_once("../ressources/includes/global-footer.php"); ?>
</body>

</html>
