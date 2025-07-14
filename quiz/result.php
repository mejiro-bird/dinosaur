<?php
	require_once $_SERVER['DOCUMENT_ROOT']. '/dinosaur/config.php';
	require_once CONTROLLER_DIR . '/quiz_controller.php';

	$ctrl = new QuizController();
	$ctrl->resultAction();
	$view = $ctrl->view;

?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>恐竜検定｜結果発表</title>
		<meta name="description" content="恐竜検定であなたの知識を腕試し！問題に挑戦！">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="icon" href="<?php echo DIR_NAME;?>img/favicon.ico">
		<link rel="apple-touch-icon" href="<?php echo DIR_NAME;?>img/apple-touch-icon.png">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho:wght@400;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="http://unpkg.com/ress/dist/ress.min.css">
		<link rel="stylesheet" href="<?php echo DIR_NAME;?>css/common.css">
		<link rel="stylesheet" href="<?php echo DIR_NAME;?>css/quiz.css">
	</head>
	<body>
		<!-- ヘッダー -->
		<?php include ROOT . 'header.php'; ?>

		<main class="result">
			<h1>結果発表</h1>

			<div class="wrapper">
				<div class="text_score"><?php echo $view['quiz_info']['score'];?>点</div>

				<div class="img_medal">
					<?php if($view['quiz_info']['score'] >= 90):/* 90点以上の場合 */?>
					<div>金メダルGET！</div>
					<img src="<?php echo DIR_NAME;?>img/gold-medal.png" alt="">
					<?php elseif($view['quiz_info']['score'] >= 70):/* 70点以上の場合 */?>
					<div>銀メダルGET！</div>
					<img src="<?php echo DIR_NAME;?>img/silver-medal.png" alt="">
					<?php elseif($view['quiz_info']['score'] >= 50):/* 50点以上の場合 */?>
					<div>銅メダルGET！</div>
					<img src="<?php echo DIR_NAME;?>img/bronze-medal.png" alt="">
					<?php else:?>
					<div>挑戦してくれてありがとう！</div>
					<?php endif;?>
				</div>
			</div>
			
			<?php if(!empty($view['login'])):/*ログイン中の場合*/?>
			<h2><?php echo $view['login']['name'];?>の記録</h2>

			<div class="item_medal">
				<div class="text">
					<img src="<?php echo DIR_NAME;?>img/gold-medal.png" alt="">
					金メダル　<?php echo $view['score']['gold_medal_num'];?>個
				</div>

				<div class="text">
					<img src="<?php echo DIR_NAME;?>img/silver-medal.png" alt="">
					銀メダル　<?php echo $view['score']['silver_medal_num'];?>個
				</div>

				<div class="text">
					<img src="<?php echo DIR_NAME;?>img/bronze-medal.png" alt="">
					銅メダル　<?php echo $view['score']['bronze_medal_num'];?>個
				</div>
			</div>
			<?php endif; /* end ログイン中の場合 */?>
			
			<div class="description">
				<div>90点以上で金メダル</div>
				<div>70点～89点で銀メダル</div>
				<div>50点～69点で銅メダル</div>
				<div>がもらえるよ</div>
			</div>

			<div class="text">また挑戦してね！</div>

			<a class="btn" href="<?php echo DIR_NAME;?>index.php">TOPに戻る</a>

		</main>

		<!-- フッター -->
		<?php include ROOT . 'footer.php'; ?>

	</body>
</html>