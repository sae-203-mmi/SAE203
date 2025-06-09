<?php
$couleur_bulle_classe = "rose";
$page_active = "index";

require_once('./ressources/includes/connexion-bdd.php');

// Code à améliorer
$id_present_url = array_key_exists("id", $_GET);

$entite = null;
if ($id_present_url) {
    $id = $_GET["id"];
    // On cherche l'article à éditer
    $requete_brute = "SELECT * FROM article WHERE id = $id";
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

    <link rel="stylesheet" href="./ressources/css/accueil.css">

    <!-- A supprimer -->
    <style>
        .no-design {
            padding: 0.5rem 1rem;
            background-color: lightgray;
            border: 1px solid gray;
            border-radius: 0.25rem;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php require_once('./ressources/includes/top-navigation.php'); ?>
    <?php
        // A supprimer si vous n'en avez pas besoin.
        // Mettre une couleur dédiée pour cette bulle, si vous gardez la bulle
        require_once('./ressources/includes/bulle.php');
    ?>

    <!-- Vous allez principalement écrire votre code HTML ci-dessous -->
    <main class="conteneur-principal conteneur-1280">
        <h1 class="titre"><?php echo $entite["titre"]; ?></h1>
        <p class="date-creation">Publié le <?php echo date("d/m/Y", strtotime($entite["date_creation"])); ?></p>
        <div class="article-image">
            <img src="<?php echo $entite["image"]; ?>" alt="Image de l'article" class="image-article">
        </div>
        <div class="article">
            <p class="chapo"><?php echo $entite["chapo"]; ?></p>
            <p class="contenu"><?php echo $entite["contenu"]; ?></p>
        </div>
    </main>
    <?php require_once('./ressources/includes/footer.php'); ?>
</body>

</html>
