<?php require_once '../tools/_db.php';
if (isset($_SESSION['is_admin']) AND ($_SESSION['is_admin'] != 1) OR empty($_SESSION['user'])){
    header('location: ../index.php');
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Administration - Mon premier blog !</title>
		<?php require 'partials/head_assets.php'; ?>
	</head>
	<body class="index-body">
		<div class="container-fluid">
			<?php require 'partials/header.php'; ?>
			<div class="row my-3 index-content">
				<?php require 'partials/nav.php'; ?>
				<main class="col-9">
					<section>

					</section>
				</main>
			</div>
			
		</div>
	</body>
</html>



