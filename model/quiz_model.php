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

	//******************
	//ユーザーの検定記録を登録する
	//入力　$user_id : ユーザーID
	//　　　$quiz_info : 検定情報
	//　　　$data : 登録データ
	//******************
	public function insertUserQuizScore($user_id,$quiz_info,$data) {
		$sql = '
			INSERT INTO user_quiz_score (
				user_id
				,level
				,max_score
				,max_score_datetime
				,latest_score
				,latest_score_datetime
				,gold_medal_num
				,silver_medal_num
				,bronze_medal_num
			) VALUES (
				:user_id
				,:level
				,:max_score
				,NOW()
				,:latest_score
				,NOW()
				,:gold_medal_num
				,:silver_medal_num
				,:bronze_medal_num
			)
		';

		try {
			$stmt = $this->_db->dbh->prepare($sql);
			$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
			$stmt->bindValue(':level', $quiz_info['level'], PDO::PARAM_INT);
			$stmt->bindValue(':max_score', $quiz_info['score'], PDO::PARAM_INT);
			$stmt->bindValue(':latest_score', $quiz_info['score'], PDO::PARAM_INT);
			$stmt->bindValue(':gold_medal_num', $data['gold_medal_num'], PDO::PARAM_INT);
			$stmt->bindValue(':silver_medal_num', $data['silver_medal_num'], PDO::PARAM_INT);
			$stmt->bindValue(':bronze_medal_num', $data['bronze_medal_num'], PDO::PARAM_INT);
			$stmt->execute();
		} catch (PDOException $e) {
			$this->_db->errAction($e); //処理を終了する
		}
		
		return;
	}

	//******************
	//ユーザーの検定記録を更新する
	//入力　$user_id : ユーザーID
	//　　　$quiz_info : 検定情報
	//　　　$data : 登録データ
	//******************
	public function updateUserQuizScore($user_id,$quiz_info,$data) {
		$sql = '
			UPDATE
				user_quiz_score
			SET
				max_score = :max_score
				,max_score_datetime = :max_score_datetime
				,latest_score = :latest_score
				,latest_score_datetime = :latest_score_datetime
				,gold_medal_num = :gold_medal_num
				,silver_medal_num = :silver_medal_num
				,bronze_medal_num = :bronze_medal_num
			WHERE
				user_id = :user_id
				AND level = :level

		';

		try {
			$stmt = $this->_db->dbh->prepare($sql);
			$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
			$stmt->bindValue(':level', $quiz_info['level'], PDO::PARAM_INT);
			$stmt->bindValue(':max_score', $data['max_score'], PDO::PARAM_INT);
			$stmt->bindValue(':max_score_datetime', $data['max_score_datetime'], PDO::PARAM_STR);
			$stmt->bindValue(':latest_score', $data['latest_score'], PDO::PARAM_INT);
			$stmt->bindValue(':latest_score_datetime', $data['latest_score_datetime'], PDO::PARAM_STR);
			$stmt->bindValue(':gold_medal_num', $data['gold_medal_num'], PDO::PARAM_INT);
			$stmt->bindValue(':silver_medal_num', $data['silver_medal_num'], PDO::PARAM_INT);
			$stmt->bindValue(':bronze_medal_num', $data['bronze_medal_num'], PDO::PARAM_INT);
			$stmt->execute();
		} catch (PDOException $e) {
			$this->_db->errAction($e); //処理を終了する
		}
		
		return;
	}

}