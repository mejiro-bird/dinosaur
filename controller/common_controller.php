<?php
/*
	共通処理
*/
class CommonController {
	public $view;

	//---検定レベルの定義---
	const QUIZ_LEVEL_BASIC = 1; //初級
	const QUIZ_LEVEL_DOCTOR = 5; //博士級
	const QUIZ_LEVEL_MST = array(
		//level_name:レベル名称　num:出題問題数
		1 => array('level_name' => '初級', 'num' => 10),
		5 => array('level_name' => '博士級', 'num' => 10)
	);



	public function __construct(){
		//セッション開始
		session_start();

		//ログイン情報を取得する
		$this->getLoginInfo();
	}


	//******************
	// ログイン情報を取得してビューへ
	//******************
	public function getLoginInfo () {
		if (!empty($_SESSION['login'])) {//ログイン情報がある場合
			$this->view['login'] = $_SESSION['login'];
		}

		return;
	}


	//******************
	// 日付をフォーマットする
	//******************
	public function getFormatDate ($date) {
		return date('Y年m月d日',strtotime($date));
	}


	//******************
	// 配列にエスケープ処理をする
	//
	// 入力　$post : エスケープ処理をしたい配列
	// 出力　$post : エスケープ処理後の配列
	//******************
	public function htmlspecialchars_all ($post) {
		foreach ($post as $key => $value) {
			$post[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); //エスケープして上書き
		}

		return ($post);
	}
	// 変数をエスケープ処理する
	public function htmlspecialchars_one ($post) {
		return htmlspecialchars($post, ENT_QUOTES, 'UTF-8');
	}


	//******************
	// ワンタイムトークンを生成する
	//
	// 出力　$token : ワンタイムトークン
	//******************
	public function make_onetimetoken () {
		//トークンを生成する
		$token = random_bytes(16);
		$csrf_token = bin2hex($token);

		//トークンをセッションに保存する
		$_SESSION['csrf_token'] = $csrf_token;

		return ($csrf_token);
	}
	//******************
	// ワンタイムトークンをチェックする
	//
	// 入力　$token : POSTされたワンタイムトークン
	// 出力　bool
	//******************
	public function check_onetimetoken ($token) {
		if (!empty($_SESSION['csrf_token'])) {//セッションにトークンがあれば
			$ses_token = $_SESSION['csrf_token']; //セッションから取り出す
		} else {
			return false; //セッションにトークンがない場合は不正
		}
		unset($_SESSION['csrf_token']); //セッションのデータを消す
		
		//セッションに保管しているトークンと比較する
		if (empty($token)) {
			return false;
		}
		if ($token == $ses_token) {//トークンが同じだったらOK
			return true;
		}

		return false;
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