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
    <link rel="stylesheet" href="./ressources/css/liste-auteurs.css">
    <link rel="icon" href="ressources/images/icone-equipederedac.png" type="image/png">
</head>

<body>
    <?php require_once('./ressources/includes/top-navigation.php'); ?>
    <?php require_once('./ressources/includes/bulle.php'); ?>

    <main class="conteneur-principal conteneur-1280">
        <h1 class="titre">L'équipe de rédaction</h1>

        <?php
        if (!$resultat_brut) {
            die("Erreur SQL : " . mysqli_error($mysqli_link));
        }
        ?>

        <section class="liste-auteurs">
        <?php while ($auteur = mysqli_fetch_assoc($resultat_brut)) { ?>
            <a href="auteur.php?id=<?php echo $auteur["id"]; ?>" class="carte-auteur">
                <img src="<?php echo htmlspecialchars($auteur["lien_avatar"]); ?>" alt="Avatar de <?php echo htmlspecialchars($auteur["prenom"]); ?>">
                <h2 class="nom-auteur"><?php echo htmlspecialchars($auteur["prenom"] . " " . $auteur["nom"]); ?></h2>
            </a>
        <?php } ?>
        </section>

    </main>

    <?php 
        require_once('./ressources/includes/footer.php');
        mysqli_free_result($resultat_brut);
        mysqli_close($mysqli_link);
    ?>
</body>
</html>


