<?php
	require_once '../config.php';
	require_once CONTROLLER_DIR . '/quiz_controller.php';

	$ctrl = new QuizController();
	$ctrl->answerAction();
	$view = $ctrl->view;

?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>恐竜検定｜答え</title>
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

		<main class="answer">
			<div class="wrapper">
				<div class="item">
					<img class="img" src="<?php echo DIR_NAME;?>img/puteranodon.png">
					<?php if($view['correct_flg']):/* 正解の場合 */?>
					<div class="correct"><img src="<?php echo DIR_NAME;?>img/maru.png"></div>
					<?php else:/* 不正解の場合 */?>
					<div class="correct"><img src="<?php echo DIR_NAME;?>img/batu.png"></div>
					<?php endif;?>
				</div>

				<h2 class="text">答え : <?php echo $view['answer_text'];?></h2>
				
				<?php if($view['last_flg']):/* 最終問題の場合 */?>
				<a class="btn" href="result.php">結果発表</a>
				<?php else:?>
				<a class="btn" href="question.php">次へ</a>
				<?php endif;?>
			</div>

		</main>

		<!-- フッター -->
		<?php include ROOT . 'footer.php'; ?>

	</body>
</html>