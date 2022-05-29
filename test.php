<?php

	$message = "Hello CSD71!";
	$num = "";

	// echo $message;

	//$movies = array("Spider man", "Harry potter", "Lord of the ring");

	// foreach($movies as $movie){
	// 	echo "<p>".$movie."</p>";
	// }
	var_dump($message);

	$movies = array();


	$movies = array(
		array("name" => "Spider man", "rating" => "9.5"),
		array("name" => "Harry potter", "rating" => "8.5"),
		array("name" => "Lord of the ring", "rating" => "9.7")
	);

	echo "<table border='1'> 
			<tr>
				<th>Name</th>
				<th>Rating</th> 
			</tr>";
	
	// for($i=0; $i<count($movies); $i++){
	// 	echo "<tr>";
	// 	echo "<td>".$movies[$i]["name"]."</td>";
	// 	echo "<td>".$movies[$i]["rating"]."</td>";
	// 	echo "</tr>";
	// }

	foreach($movies as $movie){
		echo "<tr>";
		echo "<td>".$movie["name"]."</td>";
		echo "<td>".$movie["rating"]."</td>";
		echo "</tr>";
	}

	echo "</table>"

?>