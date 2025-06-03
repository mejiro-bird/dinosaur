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

}