<?php
	require_once $_SERVER['DOCUMENT_ROOT']. '/dinosaur/config.php';
	require_once CONTROLLER_DIR . '/quiz_controller.php';

	$ctrl = new QuizController();
	$ctrl->scoreAction();
	$view = $ctrl->view;
?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>恐竜検定｜記録</title>
		<meta name="description" content="恐竜検定であなたの知識を腕試し！記録を見る。">
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

		<main class="score">
			<h1><?php echo $view['login']['name'];?>の記録</h1>

			<div class="wrapper">
				<?php foreach($ctrl::QUIZ_LEVEL_MST as $key => $row):?>
				<div class="item_level">
					<h2><?php echo $row['level_name'];?></h2>
					<div class="score_text">
						<div>
							最高記録　<?php echo $view['score'][$key]['max_score'];?>点
							<?php if(!empty($view['score'][$key]['max_score_datetime'])):/*日付が登録されている場合*/?>
							(<?php echo $ctrl->getFormatDate($view['score'][$key]['max_score_datetime']); ?>)
							<?php endif;?>
						</div>

						<div>
							最新記録　<?php echo $view['score'][$key]['latest_score'];?>点
							<?php if(!empty($view['score'][$key]['latest_score_datetime'])):/*日付が登録されている場合*/?>
							(<?php echo $ctrl->getFormatDate($view['score'][$key]['latest_score_datetime']); ?>)
							<?php endif;?>
						</div>
					</div>

					<div class="item_medal">
						<div class="text">
							<img src="<?php echo DIR_NAME;?>img/gold-medal.png" alt="">
							金メダル　<?php echo $view['score'][$key]['gold_medal_num'];?>個
						</div>

						<div class="text">
							<img src="<?php echo DIR_NAME;?>img/silver-medal.png" alt="">
							銀メダル　<?php echo $view['score'][$key]['silver_medal_num'];?>個
						</div>

						<div class="text">
							<img src="<?php echo DIR_NAME;?>img/bronze-medal.png" alt="">
							銅メダル　<?php echo $view['score'][$key]['bronze_medal_num'];?>個
						</div>
					</div>
				</div>
				<?php endforeach;?>
			</div>

			<a class="btn" href="<?php echo DIR_NAME;?>index.php">TOPに戻る</a>

		</main>

		<!-- フッター -->
		<?php include ROOT . 'footer.php'; ?>

	</body>
</html>