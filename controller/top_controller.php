<?php
/*
	TOP画面　コントローラー
*/
require_once CONTROLLER_DIR . 'common_controller.php';
require_once MODEL_DIR . 'top_model.php';

class TopController extends CommonController{
	private $_model;

	public function __construct(){
		parent::__construct();
		$this->_model = new TopModel();
	}

	//TOP画面
	public function indexAction () {

		//===メダル取得情報を取得する===
		$medal = array(); //初期化
		if (!empty($_SESSION['login'])) {//ログイン中の場合のみ取得する
			//各レベルでの記録を取得する
			foreach (self::QUIZ_LEVEL_MST as $key => $row) {
				$score[$key] = $this->_model->getUserQuizScoreById($_SESSION['login']['user_id'],$key); //指定レベルの記録を取得する
				//取得した最高メダルをセットする
				if (!empty($score[$key]['gold_medal_num'])) {//金メダルを取っている場合
					$medal[$key] = 'gold';
				} else if (!empty($score[$key]['silver_medal_num'])) {//銀メダルを取っている場合
					$medal[$key] = 'silver';
				} else if (!empty($score[$key]['bronze_medal_num'])) {//銅メダルを取っている場合
					$medal[$key] = 'bronze';
				} else {
					//何もしない
				}
			}
		}

		//ビューへ
		$this->view['medal'] = $medal;

		return;
	}

}