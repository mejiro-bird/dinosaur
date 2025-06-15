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
	//　　　$user_id : 指定IDを除外してチェックする
	//******************
	public function checkUserName($name, $user_id=NULL) {
		$sql = '
			SELECT 
				user_id
				,name
			FROM
				user_mst
			WHERE
				name = :name
		';
		if (!empty($user_id)) {//ID指定がある場合は除く
			$sql .= '
				AND user_id <> :user_id
			';
		}

		try {
			$stmt = $this->_db->dbh->prepare($sql);
			$stmt->bindValue(':name', $name, PDO::PARAM_STR);
			if (!empty($user_id)) {
				$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
			}
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

	//******************
	//ユーザー情報を更新する
	//入力　$data : 登録データ
	//******************
	public function updateUserMst($data) {
		$sql = '
			UPDATE
				user_mst
			SET
				name = :name
				,password = :password
				,update_datetime = NOW()
			WHERE
				user_id = :user_id
		';

		try {
			$stmt = $this->_db->dbh->prepare($sql);
			$stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
			$stmt->bindValue(':password', $data['password'], PDO::PARAM_STR);
			$stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
			$stmt->execute();
		} catch (PDOException $e) {
			$this->_db->errAction($e); //処理を終了する
		}
		
		return;
	}

}