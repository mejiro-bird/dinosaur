<?php
/*
	モデル　ご意見ご要望画面
*/
require_once MODEL_DIR . 'common_model.php';

class CommentModel extends CommonModel {
	public function __construct(){
		parent::__construct();
	}


	//******************
	//ご意見ご要望を新規登録する
	//入力　$data : 登録データ
	//******************
	public function insertUserComment($data) {
		$sql = '
			INSERT INTO user_comment (
				name
				,comment
				,insert_datetime
			) VALUES (
				:name
				,:comment
				,NOW()
			)
		';

		try {
			$stmt = $this->_db->dbh->prepare($sql);
			if (!empty($data['name'])) {
				$stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
			} else {
				$stmt->bindValue(':name', null , PDO::PARAM_NULL);
			}
			$stmt->bindValue(':comment', $data['comment'], PDO::PARAM_STR);
			$stmt->execute();
		} catch (PDOException $e) {
			$this->_db->errAction($e); //処理を終了する
		}
		
		return;
	}


}