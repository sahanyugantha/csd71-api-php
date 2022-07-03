<?php

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		require_once("dbconn.php");

		$dataStr = file_get_contents("php://input");
		$authData = json_decode($dataStr);

		$u_email = urldecode($authData->email);
		$u_password = sha1(urldecode($authData->password));

		$sql = "SELECT * FROM `tbl_user` WHERE `email`=? AND `password`=?";

		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, "ss", $u_email, $u_password);
		$res = mysqli_stmt_execute($stmt);
		if($res) {
			mysqli_stmt_bind_result($stmt, $id, $email, $password, $gender, $mobile);
			mysqli_stmt_store_result($stmt);
			$rows = mysqli_stmt_affected_rows($stmt);
			if($rows > 0){

				$dataObj = array();
				$userObj = array();
				while(mysqli_stmt_fetch($stmt)){
					$userObj["id"] = $id;
					$userObj["email"] = $email;
					//$userObj["password"] = $password;
					$userObj["gender"] = $gender;
					$userObj["mobile"] = $mobile;
				}
				array_push($dataObj, array("AUTH"=>"SUCCESS"));
				array_push($dataObj, array("USER"=>$userObj));

				ob_start();
				header("Content-Type:application/json");
				echo json_encode($dataObj);
				ob_end_flush();
				
			} else {
				$dataObj = array();
			//	$msg = array("AUTH" => "FAILED");
				array_push($dataObj,  array("AUTH" => "FAILED"));
				ob_start();
				header("Content-Type:application/json");
				echo json_encode($dataObj);
				ob_end_flush();
			}


		} else {
			$msg = array("MESSAGE" => "SQL Error");
			ob_start();
			header("Content-Type:application/json");
			echo json_encode($msg);
			ob_end_flush();
		}
	}

?>