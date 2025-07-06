<?php
/*
	モデル　共通処理
*/
require_once MODEL_DIR . 'db.php';

class CommonModel {
	protected $_db;

	public function __construct(){
		$this->_db = new DB();	//DBに接続する
	}


	//******************
	//指定IDとレベルの検定記録を取得する
	//入力　$user_id : ユーザーID
	//入力　$level : 検定レベル
	//******************
	public function getUserQuizScoreById($user_id,$level) {
		$sql = '
			SELECT
				max_score
				,max_score_datetime
				,latest_score
				,latest_score_datetime
				,gold_medal_num
				,silver_medal_num
				,bronze_medal_num
			FROM
				user_quiz_score
			WHERE
				user_id = :user_id
				AND level = :level
		';

		try {
			$stmt = $this->_db->dbh->prepare($sql);
			$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
			$stmt->bindValue(':level', $level, PDO::PARAM_INT);
			$stmt->execute();
		} catch (PDOException $e) {
			$this->_db->errAction($e); //処理を終了する
		}
		
		$data = $stmt->fetch();
		return $data;
	}

}