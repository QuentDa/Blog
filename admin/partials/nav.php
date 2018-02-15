<?php
	$nbUsers = $db->query("SELECT COUNT(*) FROM user")->fetchColumn();
	$nbCategories = $db->query("SELECT COUNT(*) FROM category")->fetchColumn();
	$nbArticles = $db->query("SELECT COUNT(*) FROM article")->fetchColumn();
?>
<nav class="col-3 py-2 categories-nav">
    <?php if (isset($_SESSION['user'])):?>
        <h3 class="text-center">Bienvenue dans l'administration <?php echo $_SESSION['user'];?></h3>
        <a href="index.php?logout" class="d-block btn btn-danger mb-4 mt-2">Déconnexion</a>
    <?php else: ?>
        <a class="d-block btn btn-primary mb-4 mt-2" href="../login-register.php">Connexion / inscription</a>
    <?php endif; ?>
	<ul>
		<li><a href="user-list.php">Gestion des utilisateurs (<?php echo $nbUsers; ?>)</a></li>
		<li><a href="categorylist.php">Gestion des catégories (<?php echo $nbCategories; ?>)</a></li>
		<li><a href="articlelist.php">Gestion des articles (<?php echo $nbArticles; ?>)</a></li>
	</ul>
</nav>