<?php
require_once '../tools/_db.php';
if(!isset($_SESSION['is_admin']) OR $_SESSION['is_admin'] == 0){
    header('location:../index.php');
    exit;
}
if(isset($_POST['save'])){
    $query = $db->prepare('INSERT INTO article (category_id, title, content, summary, is_published, created_at) VALUES (?, ?, ?, ?, ?, NOW())');
    $newArticle = $query->execute(
        [
            $_POST['category_id'],
            $_POST['title'],
            $_POST['content'],
            $_POST['summary'],
            $_POST['is_published'],
        ]
    );

    if($newArticle){
        if(isset($_FILES['image'])) {
            $allowed_extensions = array( 'jpg' , 'jpeg' , 'gif' , 'png' );

            $my_file_extension = pathinfo( $_FILES['image']['name'] , PATHINFO_EXTENSION);

            if (in_array($my_file_extension , $allowed_extensions) ){
                $new_file_name = md5(rand());
                $destination = '../image/article/' . $new_file_name . '.' . $my_file_extension;


                $result = move_uploaded_file( $_FILES['image']['tmp_name'], $destination);

                $lastInsertedArticleId = $db->lastInsertId();

                $query = $db->prepare('UPDATE article SET
                    image = :image
                    WHERE id = :id'
                );
                //données du formulaire
                $resultUpdateImage = $query->execute(
                    [
                        'image' => $new_file_name . '.' . $my_file_extension,
                        'id' => $lastInsertedArticleId
                    ]
                );
            }
        }

        header('location:articlelist.php');
        exit;
    }
    else {
        $message = "Impossible d'enregistrer le nouvel article...";
    }
}

if(isset($_POST['update'])){
    $query = $db->prepare('UPDATE article SET
		category_id = :category_id,
		title = :title,
		content = :content,
		summary = :summary,
		is_published = :is_published
		WHERE id = :id'
    );
    //données du formulaire
    $resultArticle = $query->execute(
        [
            'category_id' => $_POST['category_id'],
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'summary' => $_POST['summary'],
            'is_published' => $_POST['is_published'],
            'id' => $_POST['id'],
        ]
    );
    if($resultArticle){
        header('location:articlelist.php');
        exit;
    }
    else{
        $message = 'Erreur.';
    }
}
if(isset($_GET['article_id']) && isset($_GET['action']) && $_GET['action'] == 'edit'){
    $query = $db->prepare('SELECT * FROM article WHERE id = ?');
    $query->execute(array($_GET['article_id']));

    $article = $query->fetch();
}
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
            <header class="pb-3">
                <h4><?php if(isset($article)): ?>Modifier<?php else: ?>Ajouter<?php endif; ?> un article</h4>
            </header>
            <?php if(isset($message)):  ?>
                <div class="bg-danger text-white">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form action="articleform.php" method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="title">Titre :</label>
                    <input class="form-control" <?php if(isset($article)): ?>value="<?php echo $article['title']; ?>"<?php endif; ?> type="text" placeholder="Titre" name="title" id="title" />
                </div>
                <div class="form-group">
                    <label for="content">Contenu :</label>
                    <textarea class="form-control" name="content" id="content" placeholder="Contenu"><?php if(isset($article)): ?><?php echo $article['content']; ?><?php endif; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="summary">Résumé :</label>
                    <input class="form-control" <?php if(isset($article)): ?>value="<?php echo $article['summary']; ?>"<?php endif; ?> type="text" placeholder="Résumé" name="summary" id="summary" />
                </div>
                <div class="form-group">
                    <label for="summary">Image :</label>
                    <input class="form-control" type="file" name="image" id="image" />
                </div>

                <div class="form-group">
                    <label for="category_id"> Catégorie </label>
                    <select class="form-control" name="category_id" id="category_id">
                        <?php
                        $queryCategory= $db ->query('SELECT * FROM category');
                        while($category = $queryCategory->fetch()):
                            ?>
                            <option value="<?php echo $category['id']; ?>" <?php if(isset($article) && $article['category_id'] == $category['id']): ?>selected<?php endif; ?>> <?php echo $category['name']; ?> </option>

                        <?php endwhile; ?>

                    </select>
                </div>

                <div class="form-group">
                    <label for="is_published"> Publié ?</label>
                    <select class="form-control" name="is_published" id="is_published">
                        <option value="0" <?php if(isset($article) && $article['is_published'] == 0): ?>selected<?php endif; ?>>Non</option>
                        <option value="1" <?php if(isset($article) && $article['is_published'] == 1): ?>selected<?php endif; ?>>Oui</option>
                    </select>
                </div>


                <div class="text-right">
                    <?php if(isset($article)): ?>
                        <input class="btn btn-success" type="submit" name="update" value="Mettre à jour" />
                    <?php else: ?>
                        <input class="btn btn-success" type="submit" name="save" value="Enregistrer" />
                    <?php endif; ?>
                </div>

                <?php if(isset($article)): ?>
                    <input type="hidden" name="id" value="<?php echo $article['id']; ?>" />
                <?php endif; ?>

            </form>
        </section>
    </div>

</div>
</body>
</html>