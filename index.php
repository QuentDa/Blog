<?php require_once 'tools/_db.php';
if(isset($_GET['logout']) && isset($_SESSION['user'])){
    session_destroy();
    header('location:index.php');
}
?>

<!DOCTYPE html>
<html>
	<head>

		<title>Homepage - Mon premier blog !</title>

		<?php require 'partials/head_assets.php'; ?>

	</head>
	<body class="index-body">
		<div class="container-fluid">

			<?php require 'partials/header.php'; ?>

			<div class="row my-3 index-content">

				<?php require 'partials/nav.php'; ?>

				<main class="col-9">
					<section class="latest_articles">
						<header class="mb-4"><h1>Les 3 derniers articles :</h1></header>

						<?php 
						//requête avec jointure entre deux tables (article et category) sur le champ "category_id" du côté de la table "article", et "id" du côté de la table "category"
						//cette requête lie diréctement le nom de la catégorie associée à chaque article, sans avoir à refaire une requête au moment de l'affichage de chaque article
						//"category_name" sera l'alias du champ "category.name". L'alias est utilisé pour éviter les conflits dans le cas ou deux champs de deux tables différentes auraient le même nom
						$query = $db->query('
						SELECT article.* , category.name AS category_name
						FROM article
						JOIN category 
						ON article.category_id = category.id
						WHERE is_published = 1 
						ORDER BY created_at DESC 
						LIMIT 0, 3'); 
						?>

						<?php while($article = $query->fetch()): ?>
						<article class="mb-4">
							<h2><?php echo $article['title']; ?></h2>
							<!-- ici la clé "category_name" (alias de "category.name" dans la requête) a pour valeur la nom de la catégorie -->
							<b class="article-category">[<?php echo $article['category_name']; ?>]</b>
							
							<span class="article-date">Créé le <?php echo $article['created_at']; ?></span>
							<div class="article-content">
								<?php echo $article['summary']; ?>
                                <img class="d-block w-25" src="image/article/<?php echo $article['image'] ?>" alt="">
							</div>
							<a href="article.php?article_id=<?php echo $article['id']; ?>">> Lire l'article</a>
						</article>
						<?php endwhile; ?>
						
						<?php $query->closeCursor(); ?>

					</section>
					<div class="text-right">
						<a href="article_list.php">> Tous les articles</a>
					</div>
				</main>
			</div>

			<?php require 'partials/footer.php'; ?>

		</div>
	</body>
</html>
