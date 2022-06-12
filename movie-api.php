<?php

	//echo("HTTP Method ----> ".$_SERVER["REQUEST_METHOD"]);
	
	if($_SERVER["REQUEST_METHOD"] == "GET"){
		require_once("dbconn.php");

		$sql = "SELECT * FROM `tbl_movie`;";
		$stmt = mysqli_prepare($conn,$sql);

		$res = mysqli_stmt_execute($stmt);
		if($res){
			mysqli_stmt_store_result($stmt);//
			$rows = mysqli_stmt_affected_rows($stmt);

			if($rows > 0){
				//id, name, genre, duration, language, cover_img
				mysqli_stmt_bind_result($stmt, $id, $name, $genre, $duration, $lang, $url);

				$moviesArray = array();

				while(mysqli_stmt_fetch($stmt)){
					$movie_assoc = array();
					$movie_assoc["id"] = $id;
					$movie_assoc["name"] = $name;
					$movie_assoc["genre"] = $genre;
					$movie_assoc["duration"] = $duration;
					$movie_assoc["language"] = $lang;
					$movie_assoc["url"] = $url;

					array_push($moviesArray, $movie_assoc);
				}

				ob_start();
				header("Content-Type:application/json");
				echo json_encode($moviesArray);
				ob_end_flush();
				
			} else {
				$msg = array("MESSAGE"=>"No data available");
			}
			
		} else {
			$msg = array("ERROR"=>"SQL Error");
			ob_start();
			header("Content-Tye:application/json");
			echo json_encode($msg);
			ob_end_flush();
		}
		mysqli_close($conn);
	} 

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		require_once("dbconn.php");

		$dataStr = file_get_contents("php://input");//Read JSON Data as JSON String.
		$movieObject =  json_decode($dataStr, true); // Decode JSON String as Associative array.

		$name = $movieObject["name"];
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
		require_once("dbconn.php");

		$dataStr = file_get_contents("php://input");
		$movieObj = json_decode($dataStr);

		$id = $movieObj->id;
		$name = $movieObj->name;
		$genre = $movieObj->genre;
		$duration = $movieObj->duration;
		$lang = $movieObj->lang;
		$url = $movieObj->url;
		//id, name, genre, duration, language, cover_img
		$sql = "UPDATE `tbl_movie` SET `name`=?, `genre`=?, `duration`=?, `language`=?, `cover_img`=? 
				WHERE `id`=?";

		$stmt = mysqli_prepare($conn,$sql);
		mysqli_stmt_bind_param($stmt, "ssdssi", $name, $genre, $duration, $lang, $url, $id);
		$res = mysqli_stmt_execute($stmt);
		if($res){

			$rows = mysqli_stmt_affected_rows($stmt);
			if($rows > 0){
				$msg = array("MESSAGE" => "Record updated successfully.");

				ob_start();//
				header("Content-Type:application/json");
				echo json_encode($msg);
				ob_end_flush();
			} else {
				$msg = array("MESSAGE" => "Please check the values.");

				ob_start();
				header("Content-Type:application/json");
				echo json_encode($msg);
				ob_end_flush();
			}

		} else {
			$msg = array("MESSAGE" => "SQL Error");
			ob_start();
			header("Content-Type:application/json");
			echo json_encode($msg);
			ob_end_flush();
		}

		mysqli_close($conn);
	}

	if($_SERVER["REQUEST_METHOD"] == "DELETE"){
	
	}
?>