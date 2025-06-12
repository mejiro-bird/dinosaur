<?php
/*
	ログイン画面　コントローラー
*/
require_once CONTROLLER_DIR . 'common_controller.php';
require_once MODEL_DIR . 'login_model.php';

class LoginController extends CommonController{
	private $_model;

	public function __construct(){
		parent::__construct();
		$this->_model = new LoginModel();
	}

	//ログイン画面
	public function loginAction () {
		if (!empty($_GET['logout'])) {//ログアウトの場合
			unset($_SESSION['login']); //ログイン情報を削除
			$this->send_redirect(DIR_NAME.'index.php'); //ログアウト後はTOPページへ
			//リダイレクトして処理を終了
		}

		if (!empty($_POST)) {
			//===POSTデータがある場合はログインチェックする===
			//POSTデータをエスケープして取得する
			$post = $this->htmlspecialchars_all($_POST);

			//ワンタイムトークンをチェック
			if (!$this->check_onetimetoken($post['csrf_token'])) {//トークンが一致しない場合は不正
				$this->send_redirect(DIR_NAME.'index.php'); //不正アクセスの場合はTOPページへ
				//リダイレクトして処理を終了
			}

			//入力チェック
			$err = $this->err_check($post); //エラーチェック＆ログイン情報の保管
			if (empty($err)) {//ログインチェックOKの場合
				$this->send_redirect(DIR_NAME.'index.php'); //ログイン成功の場合はTOPページへ
				//リダイレクトして処理を終了
			}
			//ログイン失敗(エラーがある)場合はログイン画面を表示する
			//表示する情報をビューへ
			$this->view['data'] = $post;
			$this->view['err'] = $err;
		} else {
			//===POSTデータがない場合はログイン画面を表示する===
		}
		
		//ワンタイムトークンを作成してビューへ
		$this->view['data']['csrf_token'] = $this->make_onetimetoken();

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

		//入力の有無をチェック
		if(empty($post['name'])) {//ニックネームの入力がない場合
			$err = 'ニックネームを入力してください';
			return ($err); //以降のエラーチェックはしない
		}
		if(empty($post['password'])) {
			$err = 'パスワードを入力してください';
			return ($err); //以降のエラーチェックはしない
		}

		//===ニックネームとパスワードが正しいかチェックする===
		//指定した名前のユーザー情報を取得する
		$data = $this->_model->getUserMst($post['name'],1); //パスワードも取得する
		if (empty($data)) {//指定した名前のユーザーがいない場合
			$err = 'ユーザー名かパスワードが間違っています';
			return ($err); //以降のエラーチェックはしない
		}
		//パスワードが正しいかチェックする
		if (password_verify($post['password'],$data['password'])) {//パスワードが正しい場合
			//ログイン情報をセッションに保管する
			$_SESSION['login']['user_id'] = $data['user_id'];
			$_SESSION['login']['name'] = $data['name'];
		} else {
			$err = 'ユーザー名かパスワードが間違っています';
		}

		return ($err);
	}

}