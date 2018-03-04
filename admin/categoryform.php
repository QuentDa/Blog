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

    //redirection après enregistrement
    //si $newArticle alors l'enregistrement a fonctionné
    if($newCategory) {
        //upload de l'image si image envoyée via le formulaire
        if(isset($_FILES['image'])){
            //tableau des extentions que l'on accepte d'uploader
            $allowed_extensions = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
            //extension dufichier envoyé via le formulaire
            $my_file_extension = pathinfo( $_FILES['image']['name'] , PATHINFO_EXTENSION);
            //si l'extension du fichier envoyé est présente dans le tableau des extensions acceptées
            if ( in_array($my_file_extension , $allowed_extensions) ){

                //je génrère une chaîne de caractères aléatoires qui servira de nom de fichier
                //le but étant de ne pas écraser un éventuel fichier ayant le même nom déjà sur le serveur
                $new_file_name = md5(rand());

                //destination du fichier sur le serveur (chemin + nom complet avec extension)
                $destination = '../image/category/' . $new_file_name . '.' . $my_file_extension;
                //déplacement du fichier à partir du dossier temporaire du serveur vers sa destination
                $result = move_uploaded_file( $_FILES['image']['tmp_name'], $destination);
                //on récupère l'id du dernier enregistrement en base de données (ici l'article inséré ci-dessus)
                $lastInsertedCategoryId = $db->lastInsertId();

                //mise à jour de l'article enregistré ci-dessus avec le nom du fichier image qui lui sera associé
                $query = $db->prepare('UPDATE category SET
					image = :image
					WHERE id = :id'
                );
                $resultUpdateImage = $query->execute(
                    [
                        'image' => $new_file_name . '.' . $my_file_extension,
                        'id' => $lastInsertedCategoryId
                    ]
                );
            }
        }

        header('location:categorylist.php');
        exit;
    }
    else {
        $message = "Impossible d'enregistrer la nouvelle categorie...";
    }
}
//Si $_POST['update'] existe, cela signifie que c'est une mise à jour d'utilisateur
if(isset($_POST['update'])){

    $query = $db->prepare('UPDATE category SET
		name = :name,
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

            <form method="post" action="categoryform.php" enctype="multipart/form-data">
                <input class="form-control" type="text" name="name" placeholder="Nom de la catégorie" <?php if(isset($category)): ?>value="<?php echo $category['name']?>"<?php endif; ?> /> <br />
                <textarea class="form-control" name="description" rows="5" cols="10"><?php if(isset($category)): ?><?php echo $category['description']?><?php endif; ?></textarea><br />
                <div class="form-group">
                    <label for="summary">Image :</label>
                    <input class="form-control" type="file" name="image" id="image" />
                </div>
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
