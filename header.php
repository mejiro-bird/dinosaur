<header id="header">
	<h1 class="logo">
		<a href="<?php echo DIR_NAME;?>index.php">
			<img src="<?php echo DIR_NAME;?>img/logo.png">恐竜検定
		</a>
	</h1>

	<nav class="navi">
		<ul class="menu">
			<?php if(!empty($ctrl->view['login'])):/*ログイン中の場合*/?>
			<li><a class="uline" href="<?php echo DIR_NAME;?>user/input.php"><?php echo $ctrl->view['login']['name'];?></a></li>
			<li><a class="btn" href="<?php echo DIR_NAME;?>login.php?logout=1">ログアウト</a></li>

			<?php else:/*未ログインの場合*/?>
			<li><a class="uline" href="<?php echo DIR_NAME;?>user/input.php">新規登録</a></li>
			<li><a class="btn" href="<?php echo DIR_NAME;?>login.php">ログイン</a></li>
			<?php endif;?>
		</ul>
	</nav>

</header>