<?php
	require_once '../config.php';
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
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Stick&family=Zen+Maru+Gothic:wght@400;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="http://unpkg.com/ress/dist/ress.min.css">
		<link rel="stylesheet" href="<?php echo DIR_NAME;?>css/common.css">
		<link rel="stylesheet" href="<?php echo DIR_NAME;?>css/quiz.css">
	</head>
	<body>
		<!-- ヘッダー -->
		<?php include ROOT . 'header.php'; ?>

		<main class="question">
			<div class="wrapper">
				<h1 class="text_title"><?php echo $view['level_name'] .'　第'. $view['quiz_info']['question_num'] .'問';?></h1>

				<div class="item">
					<img class="img" src="<?php echo DIR_NAME;?>img/supino.png" alt="">
					<div class="text_q"><?php echo $view['quiz_data']['question'];?></div>
				</div>


				<form class="select" action="answer.php" method="post">
					<?php if($view['quiz_data']['question_type'] == 2):/* 問題種別が任意の選択肢の場合 */?>
					<?php foreach($view['quiz_data']['option_data'] as $row):/*選択肢を表示する*/?>
					<button class="btn" type="submit" name="answer" value="<?php echo $row['option_num'];?>"><?php echo $row['option_text'];?></button>
					<?php endforeach;?>
					<?php else:/*問題種別がYES・NOの場合*/?>
					<button class="btn" type="submit" name="answer" value="1">YES</button>
					<button class="btn" type="submit" name="answer" value="2">NO</button>
					<?php endif;?>

					<input type="hidden" name="csrf_token" value="<?php echo (!empty($view['data']['csrf_token'])) ? $view['data']['csrf_token'] : ''; ?>">
				</form>

				<div class="text">参考文献：講談社の動く図鑑move 恐竜新訂二版</div>
			</div>

		</main>

		<!-- フッター -->
		<?php include ROOT . 'footer.php'; ?>

	</body>
</html>