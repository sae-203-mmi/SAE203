<?php

$couleur_bulle_classe = "rose";
$page_active = "index";

require_once('./ressources/includes/connexion-bdd.php');


$id_present_url = array_key_exists("id", $_GET);

$entite = null;
if ($id_present_url) {
    $id = intval($_GET["id"]);
$requete_brute = "
    SELECT article.*, auteur.nom AS auteur_nom, auteur.prenom AS auteur_prenom
    FROM article
    LEFT JOIN auteur ON article.auteur_id = auteur.id
    WHERE article.id = $id";
    $resultat_brut = mysqli_query($mysqli_link, $requete_brute);
    $entite = mysqli_fetch_array($resultat_brut);
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <base href="/<?php echo $_ENV['CHEMIN_BASE']; ?>">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article - SAÉ 203</title>

    <link rel="stylesheet" href="./ressources/css/ne-pas-modifier/reset.css">
    <link rel="stylesheet" href="./ressources/css/ne-pas-modifier/fonts.css">
    <link rel="stylesheet" href="./ressources/css/ne-pas-modifier/global.css">
    <link rel="stylesheet" href="./ressources/css/ne-pas-modifier/header.css">
    <link rel="stylesheet" href="./ressources/css/ne-pas-modifier/accueil.css">
    <link rel="stylesheet" href="./ressources/css/article.css">

    <link rel="stylesheet" href="./ressources/css/accueil.css">
</head>

<body>
    <?php require_once('./ressources/includes/top-navigation.php'); ?>
    <?php
        // A supprimer si vous n'en avez pas besoin.
        // Mettre une couleur dédiée pour cette bulle, si vous gardez la bulle
        require_once('./ressources/includes/bulle.php');
    ?>

    <!-- Vous allez principalement écrire votre code HTML ci-dessous -->

    <main class="conteneur-principal conteneur-1280 article-detail">
    <?php if ($entite): ?>
        <h1 class="titre"><?php echo htmlspecialchars($entite["titre"]); ?></h1>
        <p class="date-creation date">
            <?php echo "Publié le " . date("d/m/Y", strtotime($entite["date_creation"])); ?>
        </p>
        <?php if (!empty($entite["auteur_nom"])): ?>
    <p class="auteur">Par : <?php echo htmlspecialchars($entite["auteur_prenom"] . ' ' . $entite["auteur_nom"]); ?></p>
<?php endif; ?>
        <div class="article-image">
            <img src="<?php echo htmlspecialchars($entite["image"]); ?>" alt="Image de l'article" class="image-article">
        </div>
        <div class="article">
            <p class="chapo"><?php echo htmlspecialchars($entite["chapo"]); ?></p>
            <p class="contenu"><?php echo nl2br(htmlspecialchars($entite["contenu"])); ?></p>
        </div>
    <?php else: ?>
        <p class="no-design">Aucun article trouvé.</p>
    <?php endif; ?>
</main>
    <?php require_once('./ressources/includes/footer.php'); ?>
</body>

</html>
