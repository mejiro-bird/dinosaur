<?php
	require_once 'config.php';
	require_once CONTROLLER_DIR . '/top_controller.php';

	$ctrl = new TopController();
	$ctrl->indexAction();
	$view = $ctrl->view;
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
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho:wght@400;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="http://unpkg.com/ress/dist/ress.min.css">
		<link rel="stylesheet" href="<?php echo DIR_NAME;?>css/common.css">
		<link rel="stylesheet" href="<?php echo DIR_NAME;?>css/top.css">
	</head>
	<body>
		<!-- ヘッダー -->
		<?php include ROOT . 'header.php'; ?>

		<main>
			<div class="mainvisual">恐竜検定</div>

			<?php if(empty($ctrl->view['login'])):/*未ログインの場合*/?>
			<section class="login">
				<p>ログインすると記録が残せるよ</p>
				<a class="btn" href="<?php echo DIR_NAME;?>login.php">ログイン</a>
				<div class="uline link"><a href="user/input.php">新規登録</a></div>
			</section>
			<?php endif;?>

			<section class="quiz">
				<ul class="item">
					<?php foreach($ctrl::QUIZ_LEVEL_MST as $level => $level_info):/*検定レベル別に表示させる*/?>
					<li>
						<h2 class="title"><?php echo $level_info['level_name'];?></h2>
						<div class="item2">
							<?php if(!empty($view['medal'][$level])):/*メダルを取得している場合*/?>
							<img src="img/<?php echo $view['medal'][$level];?>-medal.png">
							<?php endif;?>
							<div class="text">
								<p>全<?php echo $level_info['num'];?>問</p>
								<a href="quiz/question.php?level=<?php echo $level;?>">はじめる</a>
							</div>
						</div>
					</li>
					<?php endforeach;?>
				</ul>
			</section>

			<?php if(!empty($ctrl->view['login'])):/*ログイン中の場合*/?>
			<div class="score"><a class="btn" href="quiz/score.php">記録をみる</a></div>
			<?php endif;?>

			<div class="comment_link">ご意見・ご要望は<a class="uline" href="comment/input.php">こちら</a>まで</div>

		</main>

		<!-- フッター -->
		<?php include ROOT . 'footer.php'; ?>

	</body>
</html>