<?php
/*
	ユーザー登録画面　コントローラー
*/
require_once CONTROLLER_DIR . 'common_controller.php';
require_once MODEL_DIR . 'user_model.php';

class UserController extends CommonController{
	private $_model;

	public function __construct(){
		parent::__construct();
		$this->_model = new UserModel();
	}


	//******************
	//入力・編集画面
	//******************
	public function inputAction () {
		//入力データを取得してビューに入れる
		if (!empty($_SESSION['data'])) {
			$this->view['data'] = $_SESSION['data'];
			unset($_SESSION['data']); //セッションのデータを消す
		} else {
			//入力データがない場合、ログイン中であれば編集なのでユーザー情報を入れる
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
		$_SESSION['data'] = $post;

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
			$_SESSION['err']['err_message'] = '入力内容を修正してください';
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
		if(empty($post['name'])) {//入力がない場合
			$err['name'] = 'ニックネームを入力してください';
		} elseif (mb_strlen($post['name']) > 20) {//20文字以上の場合
			$err['name'] = '20文字以内で入力してください';
		} else {
			//同じニックネームの人がいないか確認
			if (!empty($_SESSION['login'])) {//ログイン中の場合
				$user_id = $_SESSION['login']['user_id']; //自分のIDのニックネームは除外する
			} else {
				$user_id = NULL;
			}
			
			if ($this->_model->checkUserName($post['name'], $user_id)){
				$err['name'] = 'このニックネームは既に使用されています';
			}
		}

		//パスワードのチェック
		if(empty($post['password']) || empty($post['password2'])) {//入力がない場合
			$err['password'] = 'パスワードを入力してください';
		} else if ($post['password'] !== $post['password2']) {//パスワードが同じでない場合
			$err['password'] = '同じパスワードを入力してください';
		} elseif (mb_strlen($post['password']) > 20) {//20文字以上の場合
			$err['password'] = '20文字以内で入力してください';
		} elseif (mb_strlen($post['password']) < 5) {//5文字未満の場合
			$err['password'] = '5文字以上入力してください';
		} else if (!preg_match('/\\A[!-~]+\\z/', $post['password'])) {//半角英数字と記号以外がある場合
			$err['password'] = '半角英数字と記号を使用してください';
		} else {
			//何もしない
		}

		return ($err);
	}


	//******************
	//登録完了画面
	//******************
	public function finishAction () {
		//===入力データを取得する===
		if (empty($_SESSION['data'])) {//入力データがない場合
			$this->send_redirect(DIR_NAME.'index.php'); //TOPページへリダイレクト
		}
		$data = $_SESSION['data']; //セッションからデータを取得する
		unset($_SESSION['data']); //セッションのデータを消す

		//===DB登録用にデータを成形する===
		//パスワードの成形
		$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

		//DBに登録する
		if (!empty($_SESSION['login'])) {//ログイン中は編集
			$data['user_id'] = $_SESSION['login']['user_id'];
			$this->_model->updateUserMst($data);
			//編集が完了したら、セッションに保管しているニックネームも変更する
			$_SESSION['login']['name'] = $data['name'];
			$this->view['login']['name'] = $data['name']; //ビューにも反映する
		} else {//新規登録
			$this->_model->insertUserMst($data);
		}

		return;
	}	
}