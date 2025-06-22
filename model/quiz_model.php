<?php
/*
	モデル　検定画面
*/
require_once MODEL_DIR . 'common_model.php';

class QuizModel extends CommonModel {
	public function __construct(){
		parent::__construct();
	}


	//******************
	//指定レベルの問題をランダムで取得する
	//入力　$level : 検定レベル
	//　　　$num : 問題数
	//******************
	public function getQuizMst($level, $num) {
		$sql = '
			SELECT
				quiz_id
				,question
				,question_type
				,correct_answer
			FROM
				quiz_mst
			WHERE
				level = :level
			ORDER BY
				RAND()
			LIMIT '.$num.'
		';

		try {
			$stmt = $this->_db->dbh->prepare($sql);
			$stmt->bindValue(':level', $level, PDO::PARAM_INT);
			$stmt->execute();
		} catch (PDOException $e) {
			$this->_db->errAction($e); //処理を終了する
		}
		
		$data = $stmt->fetchAll();
		return $data;
	}


	//******************
	//指定の選択肢を取得する
	//入力　$quiz_id : クイズID
	//******************
	public function getQuizOptionMstById($quiz_id) {
		$sql = '
			SELECT
				option_num
				,option_text
			FROM
				quiz_option_mst
			WHERE
				quiz_id = :quiz_id
			ORDER BY
				option_num ASC
		';

		try {
			$stmt = $this->_db->dbh->prepare($sql);
			$stmt->bindValue(':quiz_id', $quiz_id, PDO::PARAM_INT);
			$stmt->execute();
		} catch (PDOException $e) {
			$this->_db->errAction($e); //処理を終了する
		}
		
		$data = $stmt->fetchAll();
		return $data;
	}

	//******************
	//検定ログを登録する
	//入力　$user_id : ユーザーID
	//　　　$quiz_info : 検定情報
	//　　　$quiz_data : 検定出題データ
	//　　　$answer : 解答
	//******************
	public function insertQuizLog($user_id,$quiz_info,$quiz_data,$answer) {
		$sql = '
			INSERT INTO quiz_log (
				user_id
				,level
				,question_num
				,quiz_id
				,answer
				,score
				,insert_datetime
			) VALUES (
				:user_id
				,:level
				,:question_num
				,:quiz_id
				,:answer
				,:score
				,NOW()
			)
		';

		try {
			$stmt = $this->_db->dbh->prepare($sql);
			$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
			$stmt->bindValue(':level', $quiz_info['level'], PDO::PARAM_INT);
			$stmt->bindValue(':question_num', $quiz_info['question_num'], PDO::PARAM_INT);
			$stmt->bindValue(':quiz_id', $quiz_data['quiz_id'], PDO::PARAM_INT);
			$stmt->bindValue(':answer', $answer, PDO::PARAM_INT);
			$stmt->bindValue(':score', $quiz_info['score'], PDO::PARAM_INT);
			$stmt->execute();
		} catch (PDOException $e) {
			$this->_db->errAction($e); //処理を終了する
		}
		
		return;
	}

}