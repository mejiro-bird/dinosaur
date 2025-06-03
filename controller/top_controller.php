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

		return;
	}

}