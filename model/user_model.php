<?php
/*
	モデル　ユーザー登録画面
*/
require_once MODEL_DIR . 'common_model.php';

class UserModel extends CommonModel {
	public function __construct(){
		parent::__construct();
	}

	//******************
	//指定ユーザー名の人がいるかチェックする
	//入力　$name : ユーザー名
	//******************
	public function checkUserName($name) {
		$sql = '
			SELECT 
				user_id
				,name
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
		if (!empty($data)) {//指定ユーザーがいる場合
			return true;
		}

		return false; //指定ユーザーがいない
	}


	//******************
	//ユーザー情報を新規登録する
	//入力　$data : 登録データ
	//******************
	public function insertUserMst($data) {
		$sql = '
			INSERT INTO user_mst (
				name
				,password
				,insert_datetime
			) VALUES (
				:name
				,:password
				,NOW()
			)
		';

		try {
			$stmt = $this->_db->dbh->prepare($sql);
			$stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
			$stmt->bindValue(':password', $data['password'], PDO::PARAM_STR);
			$stmt->execute();
		} catch (PDOException $e) {
			$this->_db->errAction($e); //処理を終了する
		}
		
		return;
	}

}