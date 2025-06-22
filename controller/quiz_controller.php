<?php
/*
	検定画面　コントローラー
*/
require_once CONTROLLER_DIR . 'common_controller.php';
require_once MODEL_DIR . 'quiz_model.php';

class QuizController extends CommonController{
	private $_model;

	public function __construct(){
		parent::__construct();
		$this->_model = new QuizModel();
	}


	//******************
	//検定の問題画面
	//******************
	public function questionAction () {
		if (!empty($_GET['level'])) {//はじめるボタンを押した時
			unset ($_SESSION['quiz_data']); //セッションデータをクリア
			$quiz_info['level'] = $this->htmlspecialchars_one($_GET['level']); //エスケープして値を取得
			if (empty($this::QUIZ_LEVEL_MST[$quiz_info['level']])) {//指定されたレベルが存在しない場合
				$this->send_redirect(DIR_NAME.'index.php');
				//リダイレクトして処理を終了
			}

			//---一問目なので問題データを取得する---
			$quiz_data = $this->_model->getQuizMst($quiz_info['level'],$this::QUIZ_LEVEL_MST[$quiz_info['level']]['num']);
			//任意の選択肢がある問題は、選択肢を取得する
			foreach ($quiz_data as $key => $row) {
				if ($row['question_type'] == 2) {
					$quiz_data[$key]['option_data'] = $this->_model->getQuizOptionMstById($row['quiz_id']);
				}
			}
			//一問目に設定する
			$quiz_info['question_num'] = 1;
			//点数を初期化する
			$quiz_info['score'] = 0;
			//問題をセッションに保管する
			$_SESSION['quiz_data'] = $quiz_data;
			$_SESSION['quiz_info'] = $quiz_info;

		} else {//二問目以降の場合
			if (empty($_SESSION['quiz_data'])) {//問題のデータがない場合
				$this->send_redirect(DIR_NAME.'index.php');
				//リダイレクトして処理を終了
			}
			//問題データをセッションから取得する
			$quiz_data = $_SESSION['quiz_data'];
			$quiz_info = $_SESSION['quiz_info'];
			//問題番号を進める
			$quiz_info['question_num']++;
			//セッションを上書きする
			$_SESSION['quiz_info']['question_num'] = $quiz_info['question_num'];
		}
		
		//ビューへ
		$this->view['quiz_data'] = $quiz_data[$quiz_info['question_num']-1]; //出題する問題のみビューに入れる
		$this->view['quiz_info'] = $quiz_info;
		$this->view['level_name'] = $this::QUIZ_LEVEL_MST[$quiz_info['level']]['level_name'];
		//ワンタイムトークンを作成してビューへ
		$this->view['data']['csrf_token'] = $this->make_onetimetoken();

		return;
	}


	//******************
	//検定の解答画面
	//******************
	public function answerAction () {
		//POSTデータをエスケープして取得する
		if (empty($_POST)) {//POST値がない場合
			$this->send_redirect(DIR_NAME.'index.php'); //TOPページへ
			//リダイレクトして処理を終了
		}
		$post = $this->htmlspecialchars_all($_POST);

		//ワンタイムトークンをチェック
		if (!$this->check_onetimetoken($post['csrf_token'])) {//トークンが一致しない場合は不正
			$this->send_redirect(DIR_NAME.'index.php'); //TOPページへ
			//リダイレクトして処理を終了
		}
		
		//不正データでないかをチェック
		if (empty($post['answer']) || !is_numeric($post['answer'])) {//数字形式でない場合は不正
			$this->send_redirect(DIR_NAME.'index.php'); //TOPページへ
			//リダイレクトして処理を終了
		}
		
		//===正解の場合は得点を追加する===
		//問題データを取得する
		$quiz_info = $_SESSION['quiz_info'];
		$quiz_data = $_SESSION['quiz_data'][$quiz_info['question_num']-1];
		if ($post['answer']  == $quiz_data['correct_answer']) {//正解の場合
			//得点を加点する
			$quiz_info['score'] += 100/ $this::QUIZ_LEVEL_MST[$quiz_info['level']]['num'];
			//セッションを上書きする
			$_SESSION['quiz_info']['score'] = $quiz_info['score'];
			//正解フラグを立てる
			$this->view['correct_flg'] = 1;
		} else {
			//不正解にする
			$this->view['correct_flg'] = 0;
		}

		//===検定ログをつける===
		//ユーザー情報を取得する
		if (!empty($_SESSION['login'])) {
			$user_id = $_SESSION['login']['user_id'];
		} else {//未ログイン時にはnullを設定する
			$user_id = null;
		}
		$this->_model->insertQuizLog($user_id,$quiz_info,$quiz_data,$post['answer']);

		//===表示する答えを作成する===
		if ($quiz_data['question_type'] == 1) {//YES・NO形式の場合
			if ($quiz_data['correct_answer'] == 1) {
				$this->view['answer_text'] = 'YES';
			} else {
				$this->view['answer_text'] = 'NO';
			}
		} else {//任意の選択肢の場合
			$this->view['answer_text'] = $quiz_data['option_data'][$quiz_data['correct_answer']-1]['option_text'];
		}

		//===最終問題か判定する===
		if ($quiz_info['question_num'] >= $this::QUIZ_LEVEL_MST[$quiz_info['level']]['num']) {//最終問題の場合
			$this->view['last_flg'] = 1; // 最終問題にする
		} else {
			$this->view['last_flg'] = 0; //最終問題ではない
		}

		return;
	}
}