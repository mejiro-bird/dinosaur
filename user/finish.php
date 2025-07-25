<?php
	require_once '../config.php';
	require_once CONTROLLER_DIR . '/user_controller.php';

	$ctrl = new UserController();
	$ctrl->finishAction();
	$view = $ctrl->view;
?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>恐竜検定｜ユーザー登録　完了</title>
		<meta name="description" content="恐竜検定であなたの知識を腕試し！ユーザー登録すると記録が残せます。">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="icon" href="<?php echo DIR_NAME;?>img/favicon.ico">
		<link rel="apple-touch-icon" href="<?php echo DIR_NAME;?>img/apple-touch-icon.png">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho:wght@400;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="http://unpkg.com/ress/dist/ress.min.css">
		<link rel="stylesheet" href="<?php echo DIR_NAME;?>css/common.css">
		<link rel="stylesheet" href="<?php echo DIR_NAME;?>css/login_user.css">
	</head>
	<body>
		<!-- ヘッダー -->
		<?php include ROOT . 'header.php'; ?>

		<main class="user">
			<?php if(!empty($ctrl->view['login'])):/*ログイン中の場合*/?>
			<h1>ユーザー　編集　完了</h1>
			<div class="text mb20">登録が完了しました。</div>

			<div class="btn_wrapper">
				<a class="btn" href="<?php echo DIR_NAME;?>index.php">TOPに戻る</a>
			</div>

			<?php else:/*未ログインの場合*/?>
			<h1>ユーザー　新規登録　完了</h1>
			<div class="text">登録が完了しました。</div>
			<div class="text mb20">ログインしてください。</div>

			<div class="btn_wrapper">
				<a class="btn" href="<?php echo DIR_NAME;?>login.php">ログイン</a>
			</div>

			<?php endif;?>


		</main>

		<!-- フッター -->
		<?php include ROOT . 'footer.php'; ?>

	</body>
</html>