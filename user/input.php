<?php
	require_once $_SERVER['DOCUMENT_ROOT']. '/dinosaur/config.php';
	require_once CONTROLLER_DIR . '/user_controller.php';

	$ctrl = new UserController();
	$ctrl->inputAction();
	$view = $ctrl->view;

?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>恐竜検定｜ユーザー登録</title>
		<meta name="description" content="恐竜検定であなたの知識を腕試し！ユーザー登録すると記録が残せます。">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="icon" href="img/favicon.ico">
		<!--<link rel="apple-touch-icon" href="img/apple-touch-icon.png">-->
		<link rel="stylesheet" href="http://unpkg.com/ress/dist/ress.min.css">
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<!-- ヘッダー -->
		<?php include ROOT . 'header.php'; ?>

		<main>
			<h1>ユーザー　新規登録</h1>

			<form action="confirm.php" method="post">
				<dl>
					<dt><label for="name">ニックネーム</label></dt>
					<dd><input type="text" name="name" value="<?php echo (!empty($view['data']['name'])) ? $view['data']['name'] : ''; ?>"></dd>
					<div>※個人情報は入力しないでください</div>
					<?php if(!empty($view['err']['name'])):/*エラーがある場合*/?>
					<div><?php echo $view['err']['name'];?></div>
					<?php endif;?>

					<dt><label for="password">パスワード</label></dt>
					<dd><input type="password" name="password" value="<?php echo (!empty($view['data']['password'])) ? $view['data']['password'] : ''; ?>"></dd>

					<dt><label for="password2">パスワード(確認用)</label></dt>
					<dd><input type="password" name="password2" value="<?php echo (!empty($view['data']['password2'])) ? $view['data']['password2'] : ''; ?>"></dd>
					<?php if(!empty($view['err']['password'])):/*エラーがある場合*/?>
					<div><?php echo $view['err']['password'];?></div>
					<?php endif;?>

				</dl>
				<button type="submit" name="action" value="next">確認</button>
			</form>


		</main>

		<!-- フッター -->
		<?php include ROOT . 'footer.php'; ?>

	</body>
</html>