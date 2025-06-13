<?php
$couleur_bulle_classe = "violet";
$page_active = "equipe";

require_once('./ressources/includes/connexion-bdd.php');


$requete_brute = "
    SELECT * FROM auteur
";

$resultat_brut = mysqli_query($mysqli_link, $requete_brute);


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <base href="/<?php echo $_ENV['CHEMIN_BASE']; ?>">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ÉQUIPE DE RÉDACTION - SAÉ 203</title>

    <link rel="stylesheet" href="./ressources/css/ne-pas-modifier/reset.css">
    <link rel="stylesheet" href="./ressources/css/ne-pas-modifier/fonts.css">
    <link rel="stylesheet" href="./ressources/css/ne-pas-modifier/global.css">
    <link rel="stylesheet" href="./ressources/css/ne-pas-modifier/header.css">
    <link rel="stylesheet" href="./ressources/css/ne-pas-modifier/accueil.css">
    <link rel="icon" href="ressources/images/icone-equipederedac.png" type="image/png">
</head>

<body>

        <?php require_once('./ressources/includes/top-navigation.php'); ?>
    <?php
 
        // A supprimer si vous n'en avez pas besoin.
        // Mettre une couleur dédiée pour cette bulle, si vous gardez la bulle
        require_once('./ressources/includes/bulle.php');
    ?>







    <main class="conteneur-principal conteneur-1280">
        <!-- Vous allez principalement écrire votre code HTML dans cette balise -->

<?php        if (!$resultat_brut) {
    die("Erreur SQL : " . mysqli_error($mysqli_link));
}

while ($auteur = mysqli_fetch_assoc($resultat_brut)) {
    echo "<div style='border:1px solid #ccc; padding:10px; margin:10px 0'>";
    echo "<h2>" . htmlspecialchars($auteur['prenom']) . " " . htmlspecialchars($auteur['nom']) . "</h2>";
    echo "<p>Twitter : <a href='" . htmlspecialchars($auteur['lien_twitter']) . "'>" . htmlspecialchars($auteur['lien_twitter']) . "</a></p>";
    
    if (!empty($auteur['lien_avatar'])) {
        echo "<img src='" . htmlspecialchars($auteur['lien_avatar']) . "' alt='Avatar de " . htmlspecialchars($auteur['prenom']) . "' style='max-width:100px;'>";
    }

    echo "</div>";
}
?>
    </main>
    <?php require_once('./ressources/includes/footer.php'); ?>
</body>

</html>


