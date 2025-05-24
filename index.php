<?php
	require_once $_SERVER['DOCUMENT_ROOT']. '/dinosaur/config.php';
	require_once CONTROLLER_DIR . '/top_controller.php';

	$view = new TopController();
?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>恐竜検定</title>
		<meta name="description" content="恐竜検定であなたの知識を腕試し！">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="icon" href="img/favicon.ico">
		<!--<link rel="apple-touch-icon" href="img/apple-touch-icon.png">-->
		<link rel="stylesheet" href="http://unpkg.com/ress/dist/ress.min.css">
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<header id="header">

		</header>

		<main>
			<h1>恐竜検定</h1>

		</main>

		<footer id="footer">

		</footer>
	</body>
</html>