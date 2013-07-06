<?php
class PHPApi {
	public $service;
	public $information;

	public function __construct($jsonStr) {
		$jsonObject = json_decode ( $jsonStr );

		$this->service = $jsonObject->service;
		$this->information = $jsonObject->information;
	}

	public function execute() {
		$conn = mysql_connect ( "localhost", "s549974db0", "7337zxtz" ) or die ( "error" . mysql_error () ); 
		mysql_select_db ( "s549974db0", $conn ) or die ( "select db error" );//mysql_query("use s549974db0",$conn);
		mysql_query ( "set names utf-8" );

		if ($this->service == "") {
			$this->set_error ();
		} else {
			$sql = null;
			if ($this->service == "create_user") {
				$this->add_user($conn );
			} else if ($this->service == "list_user") {
				$this->list_user($conn );
			} else if($this->service=="delete_user"){
				$this->delete_user($conn );
			} else if($this->service=="update_user") {
				$this->show_list($conn );
			} else if($this->service=="query_user") {
				$this->show_list($conn );
			} else {
				$this->set_error ();
			}
		}
		mysql_close ( $conn );
	}

	private function list_user($conn ) {
		$sql = mysql_query ( "select * from user", $conn );

		$row = mysql_fetch_object ( $sql );
		$data = array ();
		do {
			$array = array ('id' => $row->id, 'username' => $row->password, 'password' => $row->password, 'type' => $row->type );
			array_push ( $data, $array );
			$row = mysql_fetch_object( $sql );
		} while ($row);

		$this->set_sucess_info ( $this->service, $data );
		if($sql) {
			mysql_free_result ( $sql );
		}
	}

	private function add_user($conn ) {
		$sql = mysql_query ( "insert into user(username,password,type) values('" . $this->information->username . "','" . $this->information->password . "'," . $this->information->type . ")", $conn );
		if ($sql) {
			$this->set_sucess ( $this->service );
			mysql_free_result ( $sql );
		} else {
			$this->set_error ();
		}
	}

	private function delete_user($conn ) {
		$sql=mysql_query("delete from user where id=".$this->information->id);
		if ($sql) {
			$this->set_sucess ( $this->service );
			mysql_free_result ( $sql );
		} else {
			$this->set_error ();
		}
	}

	private function update_user($conn ) {
		$sql=mysql_query("update user set username='".$this->information->username."', type='".$this->information->type."' where id=".$this->information->type);
		if ($sql) {
			$this->set_sucess ( $this->service );
			mysql_free_result ( $sql );
		} else {
			$this->set_error ();
		}
	}

	private function query_user($conn ) {
		$sql=mysql_query("select * from user where type='".$this->information->type."'", $conn);
		if ($sql) {
			$this->set_sucess ( $this->service );
			mysql_free_result ( $sql );
		} else {
			$this->set_error ();
		}
	}

	private function set_sucess($service) {
		$result = array ('service' => $service, 'code' => '00', 'message' => 'ok' );
		echo json_encode ( $result );
	}

	private function set_sucess_info($service, $information) {
		$result = array ('service' => $service, 'code' => '00', 'information' => $information );
		echo json_encode ( $result );
	}

	private function set_error() {
		$error = array ('code' => '-1', 'message' => 'execute error' );
		echo json_encode ( $error );
	}
}
?>