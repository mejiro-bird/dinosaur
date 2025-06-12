<?php
	require_once $_SERVER['DOCUMENT_ROOT']. '/dinosaur/config.php';
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
		<link rel="stylesheet" href="http://unpkg.com/ress/dist/ress.min.css">
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<!-- ヘッダー -->
		<?php include ROOT . 'header.php'; ?>

		<main>
			<form action="login.php" method="post">
				<dl>
					<dt><label for="name">ニックネーム</label></dt>
					<dd><input type="text" name="name" value="<?php echo (!empty($view['data']['name'])) ? $view['data']['name'] : ''; ?>"></dd>

					<dt><label for="password">パスワード</label></dt>
					<dd><input type="password" name="password" value="<?php echo (!empty($view['data']['password'])) ? $view['data']['password'] : ''; ?>"></dd>

					<?php if(!empty($view['err'])):/*エラーがある場合*/?>
					<div><?php echo $view['err'];?></div>
					<?php endif;?>

				</dl>
				<input type="hidden" name="csrf_token" value="<?php echo (!empty($view['data']['csrf_token'])) ? $view['data']['csrf_token'] : ''; ?>">
				<button type="submit" name="action" value="login">ログイン</button>
			</form>

		</main>

		<!-- フッター -->
		<?php include ROOT . 'footer.php'; ?>

	</body>
</html>