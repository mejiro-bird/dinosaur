<?php
/*
	共通処理
*/
class CommonController {
	public function __construct(){
		//セッション開始
		session_start();
	}


	//******************
	// 配列にエスケープ処理をする
	//
	// 入力　$post : エスケープ処理をしたい配列
	// 出力　$post : エスケープ処理後の配列
	//******************
	public function htmlspecialchars_all ($post) {
		if (!empty($post)) {
			foreach ($post as $key => $value) {
				$post[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); //エスケープして上書き
			}
		}

		return ($post);
	}

	//******************
	// リダイレクトする
	//
	// 入力　$url : 遷移先URL
	//******************
	public function send_redirect ($url) {
		header('Location: '.$url);
		exit;
	}
}