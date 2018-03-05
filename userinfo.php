<?php
require_once 'tools/_db.php';

if (!isset($_SESSION['user'])){
    header('location:index.php');
}

    $query = $db->prepare('SELECT * FROM user WHERE id = ?');
    $query->execute(array($_SESSION['id']));
    $loggeduser = $query->fetch();


if(isset($_POST['update'])){
    $query = $db->prepare('UPDATE user SET
		firstname = :firstname,
		lastname = :lastname,
		password = :password,
		email = :email,
		bio = :bio,
		WHERE id = :id'
    );
    //données du formulaire
    $result = $query->execute(
        [
            'firstname' => $_POST['firstname'],
            'lastname' => $_POST['lastname'],
            'password' => $_POST['password'],
            'email' => $_POST['email'],
            'bio' => $_POST['bio'],
            'id' => $_SESSION['id'],
        ]
    );
    if ($result){
        header('location:userinfo.php');
        $message = 'Infos mise à jour avec succès.';
    }
    else{
        $message = 'Erreur.';
    }

    if(isset($_POST['update'])) {
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
                $destination = '../image/user/' . $new_file_name . '.' . $my_file_extension;
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

?>

<!DOCTYPE html>
<html>
<head>

    <title>Modification de ses informations - Mon premier blog !</title>

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
                <h4>Modifier ses informations</h4>
            </header>

            <?php if(isset($message)): //si un message a été généré plus haut, l'afficher ?>
                <div class="bg-danger text-white">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <!-- Si $user existe, chaque champ du formulaire sera pré-remplit avec les informations de l'utilisateur -->

            <div class="col-12">
                
                <div class="d-flex flex-row">
                    <h3 class="text-center">Bonjour <?php echo $_SESSION['user'];?></h3>
                    <img class="d-block w-25" src="image/user/<?php echo $user['image'] ?>" alt="" width="25%">
                </div>

                <form action="userinfo.php" method="post" class="w-100" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="firstname">Prénom :</label>
                        <input class="form-control" value="<?php echo $loggeduser['firstname']; ?>" type="text" placeholder="Prénom" name="firstname" id="firstname" />
                    </div>
                    <div class="form-group">
                        <label for="lastname">Nom de famille : </label>
                        <input class="form-control" value="<?php echo $loggeduser['lastname']?>" type="text" placeholder="Nom de famille" name="lastname" id="lastname" />
                    </div>
                    <div class="form-group">
                        <label for="email">Email :</label>
                        <input class="form-control" value="<?php echo $loggeduser['email']?>" type="email" placeholder="Email" name="email" id="email" />
                    </div>
                    <div class="form-group">
                        <label for="password">Password : </label>
                        <input class="form-control" value="<?php echo $loggeduser['password']?>" type="password" placeholder="Mot de passe" name="password" id="password" />
                    </div>
                    <div class="form-group">
                        <label for="bio">Biographie :</label>
                        <textarea class="form-control" name="bio" id="bio" placeholder="Sa vie son oeuvre..."><?php echo $loggeduser['bio']?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="summary">Photo de profil :</label>
                        <input class="form-control" type="file" name="image" id="image" />
                    </div>
                    <div class="text-right">
                        <input class="btn btn-success" type="submit" name="update" value="Mettre à jour" />
                    </div>
                    <?php if(isset($user)): ?>
                        <input type="hidden" name="id" value="<?php echo $user['id']?>" />
                    <?php endif; ?>
                </form>
            </div>
        </section>
    </div>

</div>
</body>
</html>
