<?php
	require_once $_SERVER['DOCUMENT_ROOT']. '/dinosaur/config.php';
	require_once CONTROLLER_DIR . '/top_controller.php';

	$ctrl = new TopController();
	$ctrl->indexAction();

?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>恐竜検定</title>
		<meta name="description" content="恐竜検定であなたの知識を腕試し！">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="icon" href="<?php echo DIR_NAME;?>img/favicon.ico">
		<link rel="apple-touch-icon" href="<?php echo DIR_NAME;?>img/apple-touch-icon.png">
		<link rel="stylesheet" href="http://unpkg.com/ress/dist/ress.min.css">
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<!-- ヘッダー -->
		<?php include ROOT . 'header.php'; ?>

		<main>
			<h1>恐竜検定</h1>

			<?php if(empty($ctrl->view['login'])):/*未ログインの場合*/?>
			<div><a href="<?php echo DIR_NAME;?>login.php">ログイン</a></div>
			<div><a href="user/input.php">新規登録</a></div>
			<?php endif;?>

			<?php foreach($ctrl::QUIZ_LEVEL_MST as $level => $level_info):/*検定レベル別に表示させる*/?>
				<div><?php echo $level_info['level_name'];?></div>
				<div>全<?php echo $level_info['num'];?>問</div>
				<a href="quiz/question.php?level=<?php echo $level;?>">はじめる</a>
			<?php endforeach;?>

			<?php if(!empty($ctrl->view['login'])):/*ログイン中の場合*/?>
			<div><a href="quiz/score.php">記録をみる</a></div>
			<?php endif;?>

		</main>

		<!-- フッター -->
		<?php include ROOT . 'footer.php'; ?>

	</body>
</html>