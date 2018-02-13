<?php 

require_once 'tools/_db.php'; 

//selection de l'article dont l'ID est envoyé en paramètre GET
$query = $db->prepare('SELECT * FROM article WHERE id = ? AND is_published = 1');
$query->execute( array( $_GET['article_id'] ) );

$article = $query->fetch();

//si pas d'article trouvé dans la base de données
if(!$article){
	header('location:index.php');
	exit;
}

$query->closeCursor();

?>

<!DOCTYPE html>
<html>
 <head>
 
	<title><?php echo $article['title']; ?> - Mon premier blog !</title>
   
   <?php require 'partials/head_assets.php'; ?>
   
 </head>
 <body class="article-body">
	<div class="container-fluid">
		
		<?php require 'partials/header.php'; ?>
		
		<div class="row my-3 article-content">
		
			<?php require 'partials/nav.php'; ?>

			<main class="col-9">
				<article>
					<h1><?php echo $article['title']; ?></h1>
					
					<?php
						//selection de la catégorie liée à l'article
						$categoryQuery = $db->query('SELECT name FROM category WHERE id = ' . $article['category_id']);
						$articleCategoryName = $categoryQuery->fetchColumn();
					?>
					<b class="article-category">[<?php echo $articleCategoryName; ?>]</b>
					<span class="article-date">Créé le <?php echo $article['created_at']; ?></span>
					<div class="article-content">
						<?php echo $article['content']; ?>
					</div>
				</article>
			</main>
			
		</div>
		
		<?php require 'partials/footer.php'; ?>
		
	</div>
 </body>
</html>