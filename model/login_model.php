<?php
/*
	モデル　ログイン画面
*/
require_once MODEL_DIR . 'common_model.php';

class LoginModel extends CommonModel {
	public function __construct(){
		parent::__construct();
	}

	//******************
	//ユーザー情報を取得する
	//入力　$name : ユーザー名
	//　　　$password_flg : パスワードを取得する場合は1
	//******************
	public function getUserMst($name,$password_flg=0) {
		$sql = '
			SELECT 
				user_id
				,name
		';
		if ($password_flg) {//パスワードを取得する場合
			$sql .= '
				,password
			';
		}
		$sql .= '
			FROM
				user_mst
			WHERE
				name = :name
		';

		try {
			$stmt = $this->_db->dbh->prepare($sql);
			$stmt->bindValue(':name', $name, PDO::PARAM_STR);
			$stmt->execute();
		} catch (PDOException $e) {
			$this->_db->errAction($e); //処理を終了する
		}
		
		$data = $stmt->fetch();

		return $data;
	}

}