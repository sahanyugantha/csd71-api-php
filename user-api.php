<?php

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		require_once("dbconn.php");

		$dataStr = file_get_contents("php://input");
		$userObj = json_decode($dataStr);

		//id, email, password, gender, mobile
		$email = $userObj->email;
		$password = sha1($userObj->password);//md5, sha1, sha5, sha256
		$gender = $userObj->gender;
		$mobile = $userObj->mobile;

		$sql = "INSERT INTO `tbl_user` (`email`, `password`, `gender`, `mobile`) 
		VALUES (?,?,?,?);";

		$stmt = mysqli_prepare($conn,$sql);
		mysqli_stmt_bind_param($stmt,"ssss", $email, $password, $gender, $mobile);
		$res = mysqli_stmt_execute($stmt);
		if($res){
			$rows = mysqli_stmt_affected_rows($stmt);
			if($rows > 0){
				$msg = array("MESSAGE" => "Record added successfully.");
				ob_start();//
				header("Content-Type:application/json");
				echo json_encode($msg);
				ob_end_flush();
			}else {
				$msg = array("MESSAGE" => "Please check the values.");
				ob_start();
				header("Content-Type:application/json");
				echo json_encode($msg);
				ob_end_flush();
			}
		} else{
			$msg = array("MESSAGE" => "SQL Error");
			ob_start();
			header("Content-Type:application/json");
			echo json_encode($msg);
			ob_end_flush();
		}
		mysqli_close($conn);


	}

?>