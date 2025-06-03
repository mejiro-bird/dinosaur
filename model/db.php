<?php
/*
	DB接続処理
*/
class DB {

	public $dbh;
	
	public function __construct(){
		//DBへ接続する
		try {
			$this->dbh = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);

			//例外を投げるようにする
			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//連想配列で取得するようにする
			$this->dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			$this->errAction($e);
			exit;
		}
	}

	//******************
	//エラー時の処理
	//入力　$e : PDOExceptionのエラー
	//******************
	public function errAction($e) {
		//TODO::エラー内容をファイルに書き出すようにする！！
		//TODO::処理終了しエラーページを表示するようにする
		echo $e->getMessage();
		return;
	}

	public function __destruct(){
		//DB接続を終了する
		$this->dbh = null;
	}

}