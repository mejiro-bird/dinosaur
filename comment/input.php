<?php
	require_once '../config.php';
	require_once CONTROLLER_DIR . '/comment_controller.php';

	$ctrl = new CommentController();
	$ctrl->inputAction();
	$view = $ctrl->view;

?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>恐竜検定｜ご意見・ご要望</title>
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
			<h1>ご意見・ご要望</h1>

			<p class="mb20">ご意見やご要望をお寄せください。<br>参考にさせて頂きます。</p>

			<form class="item" action="confirm.php" method="post">
				<?php if(!empty($view['err']['err_message'])):?>
				<div class="err_text"><?php echo $view['err']['err_message'];?></div>
				<?php endif;?>

				<dl>
					<dt class="mb5"><label for="name">ニックネーム(任意)</label></dt>
					<dd><input class="box" type="text" name="name" value="<?php echo (!empty($view['data']['name'])) ? $view['data']['name'] : ''; ?>"></dd>
					<div class="warn_text mb20">※個人情報は入力しないでください</div>
					<?php if(!empty($view['err']['name'])):/*エラーがある場合*/?>
					<div class="err_text"><?php echo $view['err']['name'];?></div>
					<?php endif;?>

					<dt class="mb5"><label for="comment">コメント</label></dt>
					<dd>
						<textarea class="box mb20" rows="5" name="comment"><?php echo (!empty($view['data']['comment'])) ? $view['data']['comment'] : ''; ?></textarea>
					</dd>
					<?php if(!empty($view['err']['comment'])):/*エラーがある場合*/?>
					<div class="err_text"><?php echo $view['err']['comment'];?></div>
					<?php endif;?>

				</dl>
				<input type="hidden" name="csrf_token" value="<?php echo (!empty($view['data']['csrf_token'])) ? $view['data']['csrf_token'] : ''; ?>">
				<div class="user_btn"><button type="submit" name="action" value="next">確認</button></div>
			</form>


		</main>

		<!-- フッター -->
		<?php include ROOT . 'footer.php'; ?>

	</body>
</html>