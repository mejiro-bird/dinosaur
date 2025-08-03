<?php
	require_once '../config.php';
	require_once CONTROLLER_DIR . '/comment_controller.php';

	$ctrl = new CommentController();
	$ctrl->confirmAction();
	$view = $ctrl->view;
?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>恐竜検定｜ご意見・ご要望　確認</title>
		<meta name="description" content="恐竜検定であなたの知識を腕試し！ご意見やご要望をお寄せください。">
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

		<main class="comment">
			<h1>ご意見・ご要望　確認</h1>

			<div class="text mb20">下記の内容でよろしいですか。</div>

			<form class="item" action="finish.php" method="post">
				<div class="mb20">ニックネーム　<?php if(!empty($view['data']['name'])) echo $view['data']['name'];?></div>
				<div class="mb20">コメント<br>
					<?php echo $view['data']['comment'];?>
				</div>
				<div class="btn_wrapper">
					<a class="btn" href="input.php">戻る</a>
					<div class="confirm_btn"><button type="submit" name="action" value="next">登録</button></div>
				</div>
			</form>
		</main>

		<!-- フッター -->
		<?php include ROOT . 'footer.php'; ?>

	</body>
</html>