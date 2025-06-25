<?php
	require_once $_SERVER['DOCUMENT_ROOT']. '/dinosaur/config.php';
	require_once CONTROLLER_DIR . '/quiz_controller.php';

	$ctrl = new QuizController();
	$ctrl->questionAction();
	$view = $ctrl->view;

?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>恐竜検定｜問題</title>
		<meta name="description" content="恐竜検定であなたの知識を腕試し！問題に挑戦！">
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
			<h1><?php echo $view['level_name'] .'第'. $view['quiz_info']['question_num'] .'問';?></h1>

			<div>Q</div>
			<div><?php echo $view['quiz_data']['question'];?></div>

			<form action="answer.php" method="post">
				<?php if($view['quiz_data']['question_type'] == 2):/* 問題種別が任意の選択肢の場合 */?>
				<?php foreach($view['quiz_data']['option_data'] as $row):/*選択肢を表示する*/?>
				<button type="submit" name="answer" value="<?php echo $row['option_num'];?>"><?php echo $row['option_text'];?></button>
				<?php endforeach;?>
				<?php else:/*問題種別がYES・NOの場合*/?>
				<button type="submit" name="answer" value="1">YES</button>
				<button type="submit" name="answer" value="2">NO</button>
				<?php endif;?>

				<input type="hidden" name="csrf_token" value="<?php echo (!empty($view['data']['csrf_token'])) ? $view['data']['csrf_token'] : ''; ?>">
			</form>

			<div>参考文献：講談社の動く図鑑move 恐竜新訂二版</div>

		</main>

		<!-- フッター -->
		<?php include ROOT . 'footer.php'; ?>

	</body>
</html>