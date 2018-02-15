<?php require_once '../tools/_db.php';
if (isset($_SESSION['is_admin']) AND ($_SESSION['is_admin'] != 1) OR empty($_SESSION['user'])){
    header('location: ../index.php');
    exit;
}
?>


<?php
if(isset($_GET['category_id']) && isset($_GET['action']) && $_GET['action'] == 'delete'){
    $query=$db->prepare('DELETE FROM category WHERE id = ?');
    $result= $query->execute(
        [
            $_GET['category_id']
        ]
    );

    if($result){
        $message= "Supression effectuée.";
    }
    else{
        $message="Impossible de supprimer la catégorie";
    }

}


?>


<?php
$query = $db->query('SELECT * FROM category');
$categories = $query->fetchall();
?>

<!DOCTYPE html>
<html>
<head>

    <title>Administration des catégories - Mon premier blog !</title>

    <?php require 'partials/head_assets.php'; ?>

</head>
<body class="index-body">
<div class="container-fluid">

    <?php require 'partials/header.php'; ?>

    <div class="row my-3 index-content">

        <?php require 'partials/nav.php'; ?>

        <section class="col-9">
            <header class="pb-4 d-flex justify-content-between">
                <h4>Liste des catégories</h4>
                <a class="btn btn-primary" href="categoryform.php">Ajouter une catégorie</a>
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
                    <th>Nom</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach($categories as $category): ?>

                    <tr>
                        <th><?php echo htmlentities($category['id']); ?></th>
                        <td><?php echo htmlentities($category['name']); ?></td>
                        <td><?php echo htmlentities($category['description']); ?></td>
                        <td>
                            <a href="categoryform.php?category_id=<?php echo $category['id']; ?>&action=edit" class="btn btn-warning">Modifier</a>
                            <a onclick="return confirm ('Voulez-vous vraiment effectuer cette action?')" href="categorylist.php?category_id=<?php echo $category['id']; ?>&action=delete" class="btn btn-danger">Supprimer</a>
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