<?php
	require_once $_SERVER['DOCUMENT_ROOT']. '/dinosaur/config.php';
	require_once CONTROLLER_DIR . '/user_controller.php';

	$ctrl = new UserController();
	$ctrl->confirmAction();
	$view = $ctrl->view;
?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>恐竜検定｜ユーザー登録　確認</title>
		<meta name="description" content="恐竜検定であなたの知識を腕試し！ユーザー登録すると記録が残せます。">
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
			<?php if(!empty($ctrl->view['login'])):/*ログイン中の場合*/?>
			<h1>ユーザー　編集　確認</h1>
			<?php else:/*未ログインの場合*/?>
			<h1>ユーザー　新規登録　確認</h1>
			<?php endif;?>

			<div>下記の内容でよろしいですか。</div>

			<form action="finish.php" method="post">
				<dl>
					<dt>ニックネーム</dt>
					<dd><?php echo $view['data']['name'];?></dd>
				</dl>
				<a href="input.php">戻る</a>
				<button type="submit" name="action" value="next">登録</button>
			</form>
		</main>

		<!-- フッター -->
		<?php include ROOT . 'footer.php'; ?>

	</body>
</html>