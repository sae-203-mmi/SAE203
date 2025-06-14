<?php
$couleur_bulle_classe = "violet";
$page_active = "equipe";

require_once('./ressources/includes/connexion-bdd.php');



if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID d'auteur invalide.");
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM auteur WHERE id = ?";
$stmt = mysqli_prepare($mysqli_link, $sql);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) === 0) {
    die("Auteur introuvable.");
}

$auteur = mysqli_fetch_assoc($result);

$sql_articles = "SELECT * FROM article WHERE auteur_id = ?";
$stmt_articles = mysqli_prepare($mysqli_link, $sql_articles);
mysqli_stmt_bind_param($stmt_articles, 'i', $id);
mysqli_stmt_execute($stmt_articles);
$result_articles = mysqli_stmt_get_result($stmt_articles);

$articles = [];
$existance_article = false;

if ($result_articles && mysqli_num_rows($result_articles) > 0) {
    $existance_article = true;
    while ($row = mysqli_fetch_assoc($result_articles)) {
        $articles[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <base href="/<?php echo $_ENV['CHEMIN_BASE']; ?>">
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($auteur['prenom'] . ' ' . $auteur['nom']); ?> - SAÉ 203</title>

    <link rel="stylesheet" href="./ressources/css/ne-pas-modifier/reset.css" />
    <link rel="stylesheet" href="./ressources/css/ne-pas-modifier/fonts.css" />
    <link rel="stylesheet" href="./ressources/css/ne-pas-modifier/global.css" />
    <link rel="stylesheet" href="./ressources/css/ne-pas-modifier/header.css" />
    <link rel="stylesheet" href="./ressources/css/ne-pas-modifier/accueil.css"/>
    <link rel="stylesheet" href="./ressources/css/auteur.css" />
</head>

<body>
    <?php require_once('./ressources/includes/top-navigation.php'); ?>
    <?php require_once('./ressources/includes/bulle.php'); ?>

    <?php
    // facultatif
    // require_once('./ressources/includes/bulle.php');
    ?>

    <main class="conteneur-principal conteneur-1280">
    <p class="lien-retour"> <a href="./equipe-de-redac.php" >← Retour à l'équipe</a></p> 
        <div class="fiche-auteur">
            <?php if (!empty($auteur['lien_avatar'])) : ?>
                <img src="<?php echo htmlspecialchars($auteur['lien_avatar']); ?>" alt="Avatar de <?php echo htmlspecialchars($auteur['prenom']); ?>" />
            <?php endif; ?>

            <h2><?php echo htmlspecialchars($auteur['prenom'] . ' ' . $auteur['nom']); ?></h2>

            <section class="infos-auteur">
                <?php if (!empty($auteur['lien_twitter'])) : ?>
                    <p><strong>Twitter :</strong>
                        <a href="<?php echo htmlspecialchars($auteur['lien_twitter']); ?>" target="_blank" rel="noopener noreferrer">
                            <?php echo htmlspecialchars($auteur['lien_twitter']); ?>
                        </a>
                    </p>
                <?php endif; ?>
                <!-- Tu peux ajouter bio, email, ou autre ici -->
            </section>

            
        </div>

        <?php if ($existance_article) { ?>
            <h2 class="titre">Articles rédigés par <?php echo htmlspecialchars($auteur["prenom"] . " " . $auteur["nom"]); ?></h2>
            <section id="liste-articles" class="liste-articles">
                <?php foreach ($articles as $article) { ?>
                    <a href="article.php?id=<?php echo $article["id"]; ?>" class="article">
                        <figure>
                            <img src="<?php echo htmlspecialchars($article["image"]); ?>" alt="<?php echo htmlspecialchars($article["titre"]); ?>" />
                        </figure>
                        <section class="textes">
                            <h3 class="titre"><?php echo htmlspecialchars($article["titre"]); ?></h3>
                            <p class="description"><?php echo htmlspecialchars($article["chapo"]); ?></p>
                        </section>
                    </a>
                <?php } ?>
            </section>
        <?php } else { ?>
            <p>Cet auteur n'a pas encore publié d'articles.</p>
        <?php } ?>

    </main>

    <?php require_once('./ressources/includes/footer.php'); ?>
</body>

</html>

<?php
mysqli_stmt_close($stmt);
mysqli_stmt_close($stmt_articles);
mysqli_free_result($result);
mysqli_free_result($result_articles);
mysqli_close($mysqli_link);
?>