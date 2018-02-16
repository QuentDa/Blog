<?php
$query = $db->query('SELECT * FROM category');
?>


<nav class="col-3 py-2 categories-nav">

    <?php if (isset($_SESSION['user'])):?>
        <h3 class="text-center">Bonjour <?php echo $_SESSION['user'];?></h3>

        <?php if (isset($_SESSION['is_admin']) AND $_SESSION['is_admin'] == 1):?>
            <a class="d-block btn btn-primary mb-4 mt-2" href="admin/index.php">Administration</a>
    <?php endif; ?>

        <a href="index.php?logout" class="d-block btn btn-danger mb-4 mt-2">Déconnexion</a>


    <?php else: ?>
        <a class="d-block btn btn-primary mb-4 mt-2" href="login-register.php">Connexion / inscription</a>
    <?php endif; ?>


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