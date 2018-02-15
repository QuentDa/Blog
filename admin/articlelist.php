<?php require_once '../tools/_db.php';
if (isset($_SESSION['is_admin']) AND ($_SESSION['is_admin'] != 1) OR empty($_SESSION['user'])){
    header('location: ../index.php');
    exit;
}
?>


<?php
if(isset($_GET['article_id']) && isset($_GET['action']) && $_GET['action'] == 'delete'){
    $query=$db->prepare('DELETE FROM article WHERE id = ?');
    $result= $query->execute(
        [
            $_GET['article_id']
        ]
    );

    if($result){
        $message= "Supression effectuée.";
    }
    else{
        $message="Impossible de supprimer l'article";
    }

}


?>


<?php
$query = $db->query('SELECT * FROM article');
$articles = $query->fetchall();
?>

<!DOCTYPE html>
<html>
<head>

    <title>Administration des articles - Mon premier blog !</title>

    <?php require 'partials/head_assets.php'; ?>

</head>
<body class="index-body">
<div class="container-fluid">

    <?php require 'partials/header.php'; ?>

    <div class="row my-3 index-content">

        <?php require 'partials/nav.php'; ?>

        <section class="col-9">
            <header class="pb-4 d-flex justify-content-between">
                <h4>Liste des articles</h4>
                <a class="btn btn-primary" href="articleform.php">Ajouter un article</a>
            </header>


            <?php if (isset($message)): ?>
                <div class="message btn-success">
                    <?php echo $message ?>
                </div>
            <?php endif; ?>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Catégorie</th>
                    <th>Titre</th>
                    <th>Date</th>
                    <th>Résumé</th>
                    <th>Publié</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach($articles as $article): ?>

                    <tr>
                        <th><?php echo htmlentities($article['id']); ?></th>
                        <td><?php echo htmlentities($article['category_id']); ?></td>
                        <td><?php echo htmlentities($article['title']); ?></td>
                        <td><?php echo htmlentities($article['created_at']); ?></td>
                        <td><?php echo htmlentities($article['summary']); ?></td>
                        <td><?php echo htmlentities($article['is_published']); ?></td>
                        <td>
                            <a href="articleform.php?article_id=<?php echo $article['id']; ?>&action=edit" class="btn btn-warning">Modifier</a>
                            <a onclick="return confirm ('Voulez-vous vraiment effectuer cette action?')" href="articlelist.php?article_id=<?php echo $article['id']; ?>&action=delete" class="btn btn-danger">Supprimer</a>
                        </td>
                    </tr>

                <?php endforeach; ?>
                </tbody>
            </table>

        </section>

    </div>

</div>
</body>
</html>