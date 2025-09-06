<?php
	require_once 'config.php';
	require_once CONTROLLER_DIR . '/login_controller.php';

	$ctrl = new LoginController();
	$ctrl->loginAction();
	$view = $ctrl->view;

?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>恐竜検定｜ログイン</title>
		<meta name="description" content="恐竜検定であなたの知識を腕試し！会員ログインページ">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="icon" href="<?php echo DIR_NAME;?>img/favicon.ico">
		<link rel="apple-touch-icon" href="<?php echo DIR_NAME;?>img/apple-touch-icon.png">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Stick&family=Zen+Maru+Gothic:wght@400;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="http://unpkg.com/ress/dist/ress.min.css">
		<link rel="stylesheet" href="<?php echo DIR_NAME;?>css/common.css">
		<link rel="stylesheet" href="<?php echo DIR_NAME;?>css/login_user.css">
	</head>
	<body>
		<!-- ヘッダー -->
		<?php include ROOT . 'header.php'; ?>

		<main class="login">
			<form class="item" action="login.php" method="post">
				<dl>
					<dt class="mb5"><label for="name">ニックネーム</label></dt>
					<dd><input class="box mb20" type="text" name="name" value="<?php echo (!empty($view['data']['name'])) ? $view['data']['name'] : ''; ?>"></dd>

					<dt class="mb5"><label for="password">パスワード</label></dt>
					<dd><input class="box mb20" type="password" name="password" value="<?php echo (!empty($view['data']['password'])) ? $view['data']['password'] : ''; ?>"></dd>

					<?php if(!empty($view['err'])):/*エラーがある場合*/?>
					<div class="err_text"><?php echo $view['err'];?></div>
					<?php endif;?>

				</dl>
				<input type="hidden" name="csrf_token" value="<?php echo (!empty($view['data']['csrf_token'])) ? $view['data']['csrf_token'] : ''; ?>">

				<div class="login_btn"><button type="submit" name="action" value="login">ログイン</button></div>
			</form>

		</main>

		<!-- フッター -->
		<?php include ROOT . 'footer.php'; ?>

	</body>
</html>