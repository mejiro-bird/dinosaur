<?php
/*
	ご意見ご要望画面　コントローラー
*/
require_once CONTROLLER_DIR . 'common_controller.php';
require_once MODEL_DIR . 'comment_model.php';

class CommentController extends CommonController{
	private $_model;

	public function __construct(){
		parent::__construct();
		$this->_model = new CommentModel();
	}


	//******************
	//入力・編集画面
	//******************
	public function inputAction () {
		//入力データを取得してビューに入れる
		if (!empty($_SESSION['comData'])) {
			$this->view['data'] = $_SESSION['comData'];
			unset($_SESSION['comData']); //セッションのデータを消す
		} else {
			//入力データがない場合、ログイン中であればユーザー名をデフォルト値にする
			if (!empty($_SESSION['login'])) {
				$this->view['data']['name'] = $_SESSION['login']['name'];
			}
		}
		//エラーがあれば取得してビューに入れる
		if (!empty($_SESSION['err'])) {
			$this->view['err'] = $_SESSION['err'];
			unset($_SESSION['err']); //セッションのデータを消す
		}

		//ワンタイムトークンを作成してビューへ
		$this->view['data']['csrf_token'] = $this->make_onetimetoken();

		return;
	}

	//******************
	//確認画面
	//******************
	public function confirmAction () {
		//POSTデータをエスケープして取得する
		if (empty($_POST)) {//POST値がない場合
			$this->send_redirect('input.php');
			//リダイレクトして処理を終了
		}
		$post = $this->htmlspecialchars_all($_POST);
		//セッションに入れる
		$_SESSION['comData'] = $post;

		//ワンタイムトークンをチェック
		if (!$this->check_onetimetoken($post['csrf_token'])) {//トークンが一致しない場合は不正
			$_SESSION['err']['err_message'] = '不正なアクセスです';
			$this->send_redirect('input.php');
			//リダイレクトして処理を終了
		}

		//入力チェック
		$err = $this->err_check($post);
		if (!empty($err)) {//入力エラーがある場合
			//エラー内容をセッションに入れて、入力画面へリダイレクト
			$err['err_message'] = '入力内容を修正してください';
			$_SESSION['err'] = $err;
			$this->send_redirect('input.php');
			//リダイレクトして処理を終了
		}

		//ビューに入れる
		$this->view['data'] = $post;

		return;
	}
	//******************
	// 入力のエラーチェックをする
	//
	// 入力　$post : POSTデータ
	// 出力　$err : エラー内容
	//******************
	private function err_check($post) {
		$err = array(); //初期化

		//ニックネームのチェック
		if (mb_strlen($post['name']) > 20) {//20文字以上の場合
			$err['name'] = '20文字以内で入力してください';
		}

		//コメントのチェック
		if (empty($post['comment'])) {//入力がない場合
			$err['comment'] = '入力してください';
		} elseif (mb_strlen($post['comment']) > 2000) {//2000文字以上の場合
			$err['comment'] = '2000文字以内で入力してください';
		}

		return ($err);
	}


	//******************
	//登録完了画面
	//******************
	public function finishAction () {
		//===入力データを取得する===
		if (empty($_SESSION['comData'])) {//入力データがない場合
			$this->send_redirect(DIR_NAME.'index.php'); //TOPページへリダイレクト
		}
		$data = $_SESSION['comData']; //セッションからデータを取得する
		unset($_SESSION['comData']); //セッションのデータを消す

		//DBに登録する
		$this->_model->insertUserComment($data);

		return;
	}	
}