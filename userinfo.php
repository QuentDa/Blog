<?php
require_once 'tools/_db.php';

//Si $_POST['update'] existe, cela signifie que c'est une mise à jour d'utilisateur
if (!isset($_SESSION['user'])){
    header('location:index.php');
}
    $query = $db->prepare('SELECT * FROM user WHERE id = ?');
    $query->execute(array($_SESSION['user']));
    $user = $query->fetch();

if(isset($_POST['update'])){
    $query = $db->prepare('UPDATE user SET
		firstname = :firstname,
		lastname = :lastname,
		password = :password,
		email = :email,
		bio = :bio,
		is_admin = :is_admin
		WHERE id = :id'
    );
    //données du formulaire
    $result = $query->execute(
        [
            'firstname' => $_POST['firstname'],
            'lastname' => $_POST['lastname'],
            'password' => $_POST['password'],
            'email' => $_POST['email'],
            'is_admin' => $_POST['is_admin'],
            'bio' => $_POST['bio'],
            'id' => $_POST['id'],
        ]
    );
    if ($result){
        header('location:index.php');
    }
    else{
        $message = 'Erreur.';
    }
}

?>

<!DOCTYPE html>
<html>
<head>

    <title>Administration des utilisateurs - Mon premier blog !</title>

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
                <h4><?php if(isset($user)): ?>Modifier<?php else: ?>Ajouter<?php endif; ?> un utilisateur</h4>
            </header>

            <?php if(isset($message)): //si un message a été généré plus haut, l'afficher ?>
                <div class="bg-danger text-white">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <!-- Si $user existe, chaque champ du formulaire sera pré-remplit avec les informations de l'utilisateur -->

            <form action="userinfo.php" method="post">
                <div class="form-group">
                    <label for="firstname">Prénom :</label>
                    <input class="form-control" value="<?php echo $user['firstname']?>" type="text" placeholder="Prénom" name="firstname" id="firstname" />
                </div>
                <div class="form-group">
                    <label for="lastname">Nom de famille : </label>
                    <input class="form-control" value="<?php echo $user['lastname']?>" type="text" placeholder="Nom de famille" name="lastname" id="lastname" />
                </div>
                <div class="form-group">
                    <label for="email">Email :</label>
                    <input class="form-control" value="<?php echo $user['email']?>" type="email" placeholder="Email" name="email" id="email" />
                </div>
                <div class="form-group">
                    <label for="password">Password : </label>
                    <input class="form-control" value="<?php echo $user['password']?>" type="password" placeholder="Mot de passe" name="password" id="password" />
                </div>
                <div class="form-group">
                    <label for="bio">Biographie :</label>
                    <textarea class="form-control" name="bio" id="bio" placeholder="Sa vie son oeuvre..."><?php echo $user['bio']?></textarea>
                </div>
                <div class="form-group">
                    <label for="is_admin">Admin</label>
                    <input class="form-control" type="text" name="is_admin" id="is_admin">  
                </div>

                <div class="text-right">
                    <!-- Si $user existe, on affiche un lien de mise à jour -->
                    <?php if(isset($user)): ?>
                        <input class="btn btn-success" type="submit" name="update" value="Mettre à jour" />
                    <?php endif; ?>
                </div>

                <!-- Si $user existe, on ajoute un champ caché contenant l'id de l'utilisateur à modifier pour la requête UPDATE -->
                <?php if(isset($user)): ?>
                    <input type="hidden" name="id" value="<?php echo $user['id']?>" />
                <?php endif; ?>

            </form>
        </section>
    </div>

</div>
</body>
</html>
