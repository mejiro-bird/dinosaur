<header id="header">
	<span>恐竜検定</span>

	<?php if(!empty($ctrl->view['login'])):/*ログイン中の場合*/?>
	<span><a href="<?php echo DIR_NAME;?>user/input.php"><?php echo $ctrl->view['login']['name'];?></a></span>
	<span><a href="<?php echo DIR_NAME;?>login.php?logout=1">ログアウト</a></span>

	<?php else:/*未ログインの場合*/?>
	<span><a href="<?php echo DIR_NAME;?>user/input.php">新規登録</a></span>
	<span><a href="<?php echo DIR_NAME;?>login.php">ログイン</a></span>
	<?php endif;?>

</header>