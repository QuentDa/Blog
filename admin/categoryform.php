<?php require_once '../tools/_db.php';
if (isset($_SESSION['is_admin']) AND ($_SESSION['is_admin'] != 1) OR empty($_SESSION['user'])){
    header('location: ../index.php');
    exit;
}


if (isset($_POST['save']) ){
    $query = $db->prepare('INSERT INTO category (name, description) VALUES (?, ?)');
    $newCategory = $query->execute(
        [
            $_POST['name'],
            $_POST['description'],
        ]

    );
}
//Si $_POST['update'] existe, cela signifie que c'est une mise à jour d'utilisateur
if(isset($_POST['update'])){

    $query = $db->prepare('UPDATE category SET
		name = :name
		description = :description
		WHERE id = :id'
    );

    //données du formulaire
    $result = $query->execute(
        [
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'id' => $_POST['id'],
        ]
    );

    if($result){
        header('location:categorylist.php');
        exit;
    }
    else{
        $message = 'Erreur.';
    }
}

//si on modifie un utilisateur, on doit séléctionner l'utilisateur en question (id envoyé dans URL) pour pré-remplir le formulaire plus bas
if(isset($_GET['category_id']) && isset($_GET['action']) && $_GET['action'] == 'edit'){

    $query = $db->prepare('SELECT * FROM category WHERE id = ?');
    $query->execute(array($_GET['category_id']));
    //$user contiendra les informations de l'utilisateur dont l'id a été envoyé en paramètre d'URL
    $category = $query->fetch();
}

?>


<!doctype html>
<html lang="fr">
<head>

    <title>Administration des catégories - Mon premier blog !</title>

    <?php require 'partials/head_assets.php'; ?>

</head>
<body class="index-body">
<div class="container-fluid">

    <?php require 'partials/header.php'; ?>

    <div class="row my-3 index-content">

        <?php require 'partials/nav.php'; ?>

        <section class="col-9">
            <header class="pb-3">
                <!-- Si $user existe, on affiche "Modifier" SINON on affiche "Ajouter" -->
                <h4><?php if(isset($category)): ?>Modifier<?php else: ?>Ajouter<?php endif; ?> une catégorie</h4>
            </header>
            <?php if(isset($message)): //si un message a été généré plus haut, l'afficher ?>
                <div class="bg-danger text-white">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form method="post" action="categoryform.php">
                <input class="form-control" type="text" name="name" placeholder="Nom de la catégorie" <?php if(isset($category)): ?>value="<?php echo $category['name']?>"<?php endif; ?> /> <br />
                <textarea class="form-control" name="description" rows="5" cols="10"><?php if(isset($category)): ?><?php echo $category['description']?><?php endif; ?></textarea><br />

                <div class="text-right">
                    <!-- Si $user existe, on affiche un lien de mise à jour -->
                    <?php if(isset($category)): ?>
                        <input class="btn btn-success" type="submit" name="update" value="Mettre à jour" />
                        <!-- Sinon on afficher un lien d'enregistrement d'un nouvel utilisateur -->
                    <?php else: ?>
                        <input class="btn btn-success" type="submit" name="save" value="Enregistrer" />
                    <?php endif; ?>
                </div>
                <?php if(isset($category)): ?>
                    <input type="hidden" name="id" value="<?php echo $category['id']?>" />
                <?php endif; ?>
            </form>
        </section>
</body>
</html>
