<?php

	//echo("HTTP Method ----> ".$_SERVER["REQUEST_METHOD"]);
	
	if($_SERVER["REQUEST_METHOD"] == "GET"){
		echo "Response for get request";
	} 

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		require_once("dbconn.php");

		
		$dataStr = file_get_contents("php://input");//Read JSON Data as JSON String.
		$movieObject =  json_decode($dataStr, true); // Decode JSON String as Associative array.

		$name = $movieObject->name;
		$genre = $movieObject["genre"];
		$duration = $movieObject["duration"];
		$lang = $movieObject["lang"];
		$cover = $movieObject["cover_url"];

		$sql = "INSERT INTO `tbl_movie` (`name`, `genre`, `duration`, `language`, `cover_img`) 
		VALUES (?,?,?,?,?);";

		$stmt = mysqli_prepare($conn,$sql);
		mysqli_stmt_bind_param($stmt,"ssdss", $name, $genre, $duration, $lang, $cover);
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

	if($_SERVER["REQUEST_METHOD"] == "PUT"){
	
		$dataStr = file_get_contents("php://input");

	//	echo $dataStr;
		
		$movie = json_decode($dataStr, true);
		echo $movie['genre'];
		
	}

	if($_SERVER["REQUEST_METHOD"] == "DELETE"){
		echo "Response for delete request";
	}
?>