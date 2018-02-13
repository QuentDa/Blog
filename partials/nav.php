<?php
	$query = $db->query('SELECT * FROM category');
?>

<nav class="col-3 py-2 categories-nav">
	<b>Catégories :</b>
	<ul>
		<li><a href="article_list.php">Tous les articles</a></li>
		<!-- liste des catégories -->
		<?php while($category = $query->fetch()): ?>
		<li><a href="article_list.php?category_id=<?php echo $category['id']; ?>"><?php echo $category['name']; ?></a></li>
		<?php endwhile; ?>
		
		<?php $query->closeCursor(); ?>
	</ul>
</nav>