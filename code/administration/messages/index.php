<?php
require_once("../../ressources/includes/connexion-bdd.php");

$requete_brute = "SELECT * FROM message";
$resultat_brut = mysqli_query($mysqli_link, $requete_brute);

$page_courante = "messages";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include_once("../ressources/includes/head.php"); ?>
    <title>Liste messages - Administration</title>
</head>

<body>
<?php include_once "../ressources/includes/menu-principal.php"; ?>
    <header class="bg-white shadow">
        <div class="mx-auto max-w-7xl py-3 px-4">
            <p class="text-3xl font-bold text-gray-900">Liste messages reçus</p>
            <p class="text-gray-500 text-sm">Nombre de messages : <?php echo mysqli_num_rows($resultat_brut); ?></p>
        </div>
    </header>
    <main>
        <div class="mx-auto max-w-7xl py-6 px-4">
            <div class="py-6">
                <table class="w-full bg-white rounded-lg overflow-hidden border-collapse shadow">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="font-bold pl-8 py-5 text-left">Id</th>
                            <th class="font-bold pl-8 py-5 text-left">Nom</th>
                            <th class="font-bold pl-8 py-5 text-left">Prénom</th>
                            <th class="font-bold pl-8 py-5 text-left">Email</th>
                            <th class="font-bold pl-8 py-5 text-left">Contenu</th>
                            <th class="font-bold pl-8 py-5 text-left">Type</th>
                            <th class="font-bold pl-8 py-5 text-left">Date de création</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($element = mysqli_fetch_array($resultat_brut, MYSQLI_ASSOC)) {
                            $date_creation = new DateTime($element["date_creation"]);
                            ?>
                            <tr class="odd:bg-neutral-50 border-b-2 border-b-gray-100 last:border-b-0 first:border-t-2 first:border-t-gray-200">
                                <td class="pl-8 p-4 font-bold" data-label="Id"><?php echo $element["id"]; ?></td>
                                <td class="pl-8 p-4" data-label="Nom"><?php echo $element["nom"]; ?></td>
                                <td class="pl-8 p-4" data-label="Prénom"><?php echo $element["prenom"]; ?></td>
                                <td class="pl-8 p-4" data-label="Email"><?php echo $element["email"]; ?></td>
                                <td class="pl-8 p-4" data-label="Contenu"><?php echo $element["contenu"]; ?></td>
                                <td class="pl-8 p-4" data-label="Type"><?php echo $element["type"]?></td>
                                <td class="pl-8 p-4" data-label="Date de Création">
                                    <time datetime="<?php echo $date_creation->format('d/m/Y H:i:s'); ?>">
                                        <?php echo $date_creation->format('d/m/Y H:i:s'); ?>
                                    </time>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <?php require_once("../ressources/includes/global-footer.php"); ?>
</body>

</html>
