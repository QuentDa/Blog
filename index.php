<?php require_once 'tools/_db.php'; ?>

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

						<!-- les trois derniers articles -->

						<?php
                        $query = $db->query('
						SELECT art.* , cat.name AS category_name
						FROM article art
						JOIN category cat
						ON art.category_id = cat.id
						WHERE is_published = 1
						ORDER BY created_at
						DESC LIMIT 0, 3');
                        ?>


						<?php while($article = $query->fetch()): ?>
						<article class="mb-4">
							<h2><?php echo $article['title']; ?></h2>

							<?php
								//selection de la catégorie liée à l'article en cours d'affichage par la boucle
								$categoryQuery = $db->query('SELECT name FROM category WHERE id = ' . $article['category_id']);
								$articleCategoryName = $categoryQuery->fetchColumn();
							?>
							
							<b class="article-category">[<?php echo $articleCategoryName; ?>]</b>
							
							<span class="article-date">Créé le <?php echo $article['created_at']; ?></span>
							<div class="article-content">
								<?php echo $article['summary']; ?>
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







<?php 
/*$query = $db->query('
SELECT a.* , c.name AS category_name
FROM article a
JOIN category c ON a.category_id = c.id
WHERE is_published = 1 
ORDER BY created_at 
DESC LIMIT 0, 3');*/
?>
<!--<b class="article-category">[<?php echo $article['category_name']; ?>]</b>-->
