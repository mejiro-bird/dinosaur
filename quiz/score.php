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
		<link rel="stylesheet" href="http://unpkg.com/ress/dist/ress.min.css">
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<!-- ヘッダー -->
		<?php include ROOT . 'header.php'; ?>

		<main>
			<h1><?php echo $view['login']['name'];?>の記録</h1>

			<?php foreach($ctrl::QUIZ_LEVEL_MST as $key => $row):?>
			<div><?php echo $row['level_name'];?></div>
			<div>
				最高記録
				<?php echo $view['score'][$key]['max_score'];?>点
				<?php if(!empty($view['score'][$key]['max_score_datetime'])):/*日付が登録されている場合*/?>
				(<?php echo $ctrl->getFormatDate($view['score'][$key]['max_score_datetime']); ?>)
				<?php endif;?>
			</div>

			<div>
				最新記録
				<?php echo $view['score'][$key]['latest_score'];?>点
				<?php if(!empty($view['score'][$key]['latest_score_datetime'])):/*日付が登録されている場合*/?>
				(<?php echo $ctrl->getFormatDate($view['score'][$key]['latest_score_datetime']); ?>)
				<?php endif;?>
			</div>
			
			<table>
				<tbody>
					<tr>
						<td><img src="<?php echo DIR_NAME;?>img/gold-medal.png" alt=""></td>
						<td>金メダル</td>
						<td><?php echo $view['score'][$key]['gold_medal_num'];?>個</td>
					<tr>
					<tr>
						<td><img src="<?php echo DIR_NAME;?>img/silver-medal.png" alt=""></td>
						<td>銀メダル</td>
						<td><?php echo $view['score'][$key]['silver_medal_num'];?>個</td>
					<tr>
					<tr>
						<td><img src="<?php echo DIR_NAME;?>img/bronze-medal.png" alt=""></td>
						<td>銅メダル</td>
						<td><?php echo $view['score'][$key]['bronze_medal_num'];?>個</td>
					<tr>
				</tbody>
			</table>
			<?php endforeach;?>
			

			<a href="<?php echo DIR_NAME;?>index.php">TOPに戻る</a>

		</main>

		<!-- フッター -->
		<?php include ROOT . 'footer.php'; ?>

	</body>
</html>