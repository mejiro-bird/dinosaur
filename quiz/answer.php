<?php
	require_once $_SERVER['DOCUMENT_ROOT']. '/dinosaur/config.php';
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
		<link rel="stylesheet" href="http://unpkg.com/ress/dist/ress.min.css">
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<!-- ヘッダー -->
		<?php include ROOT . 'header.php'; ?>

		<main>
			<?php if($view['correct_flg']):/* 正解の場合 */?>
			<div>正解</div>
			<div>〇</div>
			<?php else:/* 不正解の場合 */?>
			<div>不正解</div>
			<div>X</div>
			<?php endif;?>

			<div>答え</div>
			<div><?php echo $view['answer_text'];?></div>
			
			<?php if($view['last_flg']):/* 最終問題の場合 */?>
			<a href="result.php">結果発表</a>
			<?php else:?>
			<a href="question.php">次へ</a>
			<?php endif;?>

		</main>

		<!-- フッター -->
		<?php include ROOT . 'footer.php'; ?>

	</body>
</html>