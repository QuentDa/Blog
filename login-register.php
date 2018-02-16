<?php

require_once 'tools/_db.php';

if (isset($_SESSION['user'])){
    header('location:index.php');
    exit;
}

if(isset($_POST['login'])) {
    if (empty($_POST['email']) OR empty($_POST['password'])) {
        $message = "Merci de remplir tous les champs";
    } else {
        $query = $db->prepare('SELECT * FROM user WHERE email = ? AND password = ?');
        $query->execute(array($_POST['email'], $_POST['password']));
        $user = $query->fetch();
        if ($user) {

            //TADAM !!!
            $_SESSION['is_admin'] = $user['is_admin'];
            //vois les choses plus simplement, peu importe que le mec qui descend de ta base de donnée soit admin ou pas, tu lui créés son attribut de session avec la valeur de son is_admin (qui vaudra donc 1 pour les admins) ou 0 pour les bouzeux, et voilà tout...


            $_SESSION['user'] = $user['firstname'];
            header('location:index.php');
            //je remets le exit, inutile de continuer le script
            exit;
        } else {
            $message = 'Mauvais identifiants';
        }
    }
}


?>

<!DOCTYPE html>
<html>
 <head>
 
	<title>Login - Mon premier blog !</title>
   
   <?php require 'partials/head_assets.php'; ?>
   
 </head>
 <body class="article-body">
	<div class="container-fluid">
		
		<?php require 'partials/header.php'; ?>
		
		<div class="row my-3 article-content">
		
			<?php require 'partials/nav.php'; ?>

			<main class="col-9">
				
				<ul class="nav nav-tabs justify-content-center nav-fill" role="tablist">
					<li class="nav-item">
						<a class="nav-link <?php if(isset($_POST['login']) || !isset($_POST['register'])): ?>active<?php endif; ?>" data-toggle="tab" href="#login" role="tab">Connexion</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php if(isset($_POST['register'])): ?>active<?php endif; ?>" data-toggle="tab" href="#register" role="tab">Inscription</a>
					</li>
				</ul>

				<div class="tab-content">
					<div class="tab-pane container-fluid <?php if(isset($_POST['login']) || !isset($_POST['register'])): ?>active<?php endif; ?>" id="login" role="tabpanel">
					
						<form action="login-register.php" method="post" class="p-4 row flex-column">
						
							<h4 class="pb-4 col-sm-8 offset-sm-2">Connexion</h4>

                            <?php if (isset($message)): ?>
                            <?php echo $message; ?>
                            <?php endif; ?>
							
							<div class="form-group col-sm-8 offset-sm-2">
								<label for="email">Email</label>
								<input class="form-control" value="" type="email" placeholder="Email" name="email" id="email" />
							</div>
							
							<div class="form-group col-sm-8 offset-sm-2">
								<label for="password">Mot de passe</label>
								<input class="form-control" value="" type="password" placeholder="Mot de passe" name="password" id="password" />
							</div>
							
							<div class="text-right col-sm-8 offset-sm-2">
								<input class="btn btn-success" type="submit" name="login" value="Valider" />
							</div>
							
						</form>
					
					</div>
					<div class="tab-pane container-fluid <?php if(isset($_POST['register'])): ?>active<?php endif; ?>" id="register" role="tabpanel">

						<form action="login-register.php" method="post" class="p-4 row flex-column">
						
							<h4 class="pb-4 col-sm-8 offset-sm-2">Inscription</h4>
						
							<div class="form-group col-sm-8 offset-sm-2">
								<label for="firstname">Prénom <b class="text-danger">*</b></label>
								<input class="form-control" value="" type="text" placeholder="Prénom" name="firstname" id="firstname" />
							</div>
							<div class="form-group col-sm-8 offset-sm-2">
								<label for="lastname">Nom de famille</label>
								<input class="form-control" value="" type="text" placeholder="Nom de famille" name="lastname" id="lastname" />
							</div>
							<div class="form-group col-sm-8 offset-sm-2">
								<label for="email">Email <b class="text-danger">*</b></label>
								<input class="form-control" value="" type="email" placeholder="Email" name="email" id="email" />
							</div>
							<div class="form-group col-sm-8 offset-sm-2">
								<label for="password">Mot de passe <b class="text-danger">*</b></label>
								<input class="form-control" value="" type="password" placeholder="Mot de passe" name="password" id="password" />
							</div>
							<div class="form-group col-sm-8 offset-sm-2">
								<label for="password_confirm">Confirmation du mot de passe <b class="text-danger">*</b></label>
								<input class="form-control" value="" type="password" placeholder="Confirmation du mot de passe" name="password_confirm" id="password_confirm" />
							</div>
							<div class="form-group col-sm-8 offset-sm-2">
								<label for="bio">Biographie</label>
								<textarea class="form-control" name="bio" id="bio" placeholder="Ta vie Ton oeuvre..."></textarea>
							</div>
							
							<div class="text-right col-sm-8 offset-sm-2">
								<p class="text-danger">* champs requis</p>
								<input class="btn btn-success" type="submit" name="register" value="Valider" />
							</div>
						
						</form>

					</div>
				</div>
			</main>
			
		</div>
		
		<?php require 'partials/footer.php'; ?>
		
	</div>
 </body>
</html>

<?php
//durée de vie d'une session dans le php.ini (en secondes, laisser 0 pour détruire à la fermeture du navigateur) :
//session.gc_max_lifetime = 600 //ici 600 secondes
//OU session.lifetime = 600 //identique à l'autre paramètre

//les données se session sont accessibles partout (sur toutes les pages du site), tant que la session existe

//session_start() pour démarer la session liée à l'IP. JAMAIS APRES AVOIR DEJA GENERE DU HTML => en début de fichier, donc
//$_SESSION variable superglobale des infos en SESSION
//$_SESSION['firstName'] = 'Maxime';
//echo $_SESSION['firstName'];
//session_destroy() pour détruire une session (exemple : déconnexion utilisateur)

//unset() détruit une variable ou une partie d'un tableau
//unset( $_SESSION["cartProducts"]["2"] ); //supprimer une donnée precise de la session
//ici on supprimer le produit 2 du panier

?>
