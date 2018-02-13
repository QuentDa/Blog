<?php require_once '../tools/_db.php';


if (isset($_POST['save']) ){
    $query = $db->prepare('INSERT INTO article (category_id, title,  content, summary, is_published, created_at) VALUES (?, ?, ?, ?, ?, NOW())');
    $newArticle = $query->execute(
        [
            $_POST['category_id'],
            $_POST['title'],
            $_POST['content'],
            $_POST['summary'],
            $_POST['is_published'],
        ]

    );
}
//Si $_POST['update'] existe, cela signifie que c'est une mise à jour d'utilisateur
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
    $result = $query->execute(
        [
            'category_id' => $_POST['category_id'],
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'summary' => $_POST['summary'],
            'is_published' => $_POST['is_published'],
            'id' => $_POST['id'],
        ]
    );

    if($result){
        header('location:articlelist.php');
        exit;
    }
    else{
        $message = 'Erreur.';
    }
}

//si on modifie un utilisateur, on doit séléctionner l'utilisateur en question (id envoyé dans URL) pour pré-remplir le formulaire plus bas
if(isset($_GET['article_id']) && isset($_GET['action']) && $_GET['action'] == 'edit'){

    $query = $db->prepare('SELECT * FROM article WHERE id = ?');
    $query->execute(array($_GET['article_id']));
    //$user contiendra les informations de l'utilisateur dont l'id a été envoyé en paramètre d'URL
    $article = $query->fetch();
}

?>


<!doctype html>
<html lang="fr">
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
        <!-- Si $user existe, on affiche "Modifier" SINON on affiche "Ajouter" -->
        <h4><?php if(isset($article)): ?>Modifier<?php else: ?>Ajouter<?php endif; ?> un article</h4>
    </header>
                <?php if(isset($message)): //si un message a été généré plus haut, l'afficher ?>
                    <div class="bg-danger text-white">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

    <form method="post" action="articleform.php">
        <label>Choix de la catégorie</label>
        <?php $query = $db->query('SELECT * FROM category');?>
        <select class="form-control" name="category_id">

            <?php while ( $category = $query->fetch()) : ?>
                <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
            <?php endwhile; ?>
            <?php $query->closeCursor(); ?> ?>
        </select><br />

        <label>Titre :</label> <input class="form-control" type="text" name="title" <?php if(isset($article)): ?>value="<?php echo $article['title']?>"<?php endif; ?>><br />
        <label>Résumé de l'article</label><input class="form-control" type="text" name="summary" <?php if(isset($article)): ?>value="<?php echo $article['summary']?>"<?php endif; ?>><br />
        <label>Contenu de l'article</label> <textarea class="form-control" name="content" ><?php if(isset($article)): ?><?php echo $article['content']?><?php endif; ?></textarea><br />
        <label>Publier l'article tout de suite</label>

        <select class="form-control" name="is_published">
            <option value="0" <?php if(isset($article) && $article['is_published'] == 0): ?>selected<?php endif; ?>>Non</option>
            <option value="1" <?php if(isset($article) && $article['is_published'] == 1): ?>selected<?php endif; ?>>Oui</option>

        </select><br />

        <div class="text-right">
            <!-- Si $user existe, on affiche un lien de mise à jour -->
            <?php if(isset($article)): ?>
                <input class="btn btn-success" type="submit" name="update" value="Mettre à jour" />
                <!-- Sinon on afficher un lien d'enregistrement d'un nouvel utilisateur -->
            <?php else: ?>
                <input class="btn btn-success" type="submit" name="save" value="Enregistrer" />
            <?php endif; ?>
        </div>
        <?php if(isset($article)): ?>
            <input type="hidden" name="id" value="<?php echo $article['id']?>" />
        <?php endif; ?>
    </form>
            </section>
</body>
</html>
