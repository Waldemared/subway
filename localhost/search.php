<?php
	header ("Content-Type: text/html; charset=utf-8");
?>

<?php
	$hostname = "127.0.0.1:3306";
	$username = "root";
	$password = "";
	$dbName = "subway";
	$connection = mysqli_connect($hostname,$username,$password) OR DIE ("Can't create a copnnection!");
		mysqli_select_db($connection, "$dbName") or die("Can't select a database!");
		mysqli_set_charset($connection, "utf8");
	$minYear = mysqli_fetch_assoc(mysqli_query($connection, "select min(foundation_year) as min_year from station"))["min_year"];
	$maxYear = mysqli_fetch_assoc(mysqli_query($connection, "select max(foundation_year) as max_year from station"))["max_year"];
	$name = $_GET['name'];
	$reqMinYear = is_numeric($_GET['year_min']) ? $_GET['year_min'] : $minYear;
	$reqMaxYear = is_numeric($_GET['year_max']) ? $_GET['year_max'] : $maxYear;
	$lineEnd = $_GET['line'] == 0 ? "" : " and l.id = " . $_GET['line'];
	$lineEnd = $lineEnd . " order by s.name";
	$linesQuery = "select s.name as station_name, s.path as station_path, s.foundation_year as station_fyear, s.position as station_position, l.id as line_id, l.path as line_path, l.name as line_name from station s inner join line l on s.line_id=l.id where s.name like '%" . $name . "%' and s.foundation_year >= $reqMinYear and s.foundation_year <= $reqMaxYear" . $lineEnd;
	echo $lineQuery;
	$linesResult = mysqli_query($connection, $linesQuery);
?>
<html>
<head>
	<meta http-equiv = "Content-Type" content ="text/html; charset=utf-8" />
	<title>Phonebook</title>
	<style>
		td {
			padding: 10px;
		}
	</style>
</head>
<html>
<head>
	<meta http-equiv = "Content-Type" content ="text/html; charset=utf-8" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="/style/card.css">
	<link rel="stylesheet" type="text/css" href="/style/main.css">
	<link rel="stylesheet" type="text/css" href="/style/header.css">
	<link rel="stylesheet" type="text/css" href="/style/search.css">
	<title></title>
	<style>
		td {
			padding: 10px;
		}
	</style>
</head>
<body>
	<?php include('./header.php'); ?>
	<div class="content">
	<?php
			echo "<div class=\"search_block\">";
			echo "Найдено станций: " . mysqli_num_rows($linesResult);
			echo "<form action=\"/search.php\" id=\"search_block\">
					<input type=\"text\" name=\"name\" value=\"$name\"></input>
					<input type=\"number\" name=\"year_min\" value=\"$reqMinYear\" min=\"$minYear\" max=\"$maxYear\"></input>
					<input type=\"number\" name=\"year_max\" value=\"$reqMaxYear\" min=\"$minYear\" max=\"$maxYear\"></input>
					<select name=\"line\" form=\"search_block\">
						<option value=\"0\">All</option>";
			$lineResult = mysqli_query($connection, "select name, id from line order by id");
			while($lineRow = mysqli_fetch_assoc($lineResult)) {
				echo "<option " . ($_GET["line"] == $lineRow["id"] ? "selected" : "") . " value=\"" . $lineRow["id"] . "\">" . $lineRow["name"] . "</option>";
			}
			echo "	</select>
					<input type=\"submit\" value=\"Найти\">
				</form>";
			echo "</div>";
			echo "<div class=\"card_container\">";
			for ($i = 1; $station_info = mysqli_fetch_assoc($linesResult); $i++) {
				echo "<div class=\"card\">
				<a href=\"/observe.php?line=" . $station_info["line_id"] . "&station=" . $station_info["station_position"] . "\">
				<img src=\"/image/" . $station_info['line_path'] . "/" . $station_info['station_position'] . "_main.jpg\">
					</a>
				<div class=\"card_content\">
					<h4><b>" . $station_info['station_name'] . "</b></h4>
					</div></div>";
				}
				echo "</div>";
		if (true) {
			echo "<pre>";
			print_r($line);
			echo "</pre>";
		}


/*
		$name = $_POST["name"];
		$areacode = $_POST["areacode"];
		$phonenum = $_POST["phonenum"];
		$group = $_POST["group"];

		if ($name != "" && $areacode != "" && $phonenum != ""
				&& is_numeric($areacode) && is_numeric($phonenum)) {
			$query = "INSERT INTO numbers (name, areacode, phonenum, g_id) VALUES (\"$name\", $areacode, $phonenum, $group)";
			if(!mysqli_query($connection, $query)) {
				die('Error:'. mysqli_error($connection));
			}
			echo "1 record added";
		}

		$query = "SELECT*FROM numbers n LEFT JOIN groups g ON g.id=n.g_id ORDER BY n.name";
		$result = mysqli_query($connection, $query);

		if(mysqli_num_rows($result) == 0) {
			echo "Sorry, empty book <br><br>";
		} else {
			echo "<table border='1' cols='4' cellpadding='0' cellspacing='0'>";
			echo "<tr><td>Name</td><td>Areacode</td><td>Phonenum</td><td>Group</td></tr>";
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<tr>";
				echo "<td>".$row["name"]."</td>";
				echo "<td>".$row["areacode"]."</td>";
				echo "<td>".$row["phonenum"]."</td>";
				echo "<td>".$row["group_name"]."</td>";
				echo "</tr>";
			}	
			echo "</table><br>";
		}

		echo "<form action='/phonebook/index.php' method='post' name='phonebook_form'>";
		echo "<table border='0' cols='4' cellpadding='0' cellspacing='0' width='400'>";
		echo "<tr>";
		echo "<td>Name: <input type='text' name='name'></input></td>";
		echo "<td>Areacode: <input type='text' name='areacode'></input></td>";
		echo "<td>Phone: <input type='text' name='phonenum'></input></td>";
		echo "<td>Group: <select name='group'>";
		$query = "SELECT*FROM groups ORDER BY group_name";
		$result = mysqli_query($connection, $query);
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<option value='".$row["id"]."'>".$row["group_name"]."</option>";
		}
		echo "</select></td>";
		echo "</tr>";
		echo "</table>";
		echo "<table border='0' cols='3' cellpadding='0' cellspacing='0'>";
		echo "<tr>";
		echo "<td><input type='submit' name='insert' value='Insert'></input></td>";
		echo "</tr>";
		echo "</table>";
		echo "</form>";
*/
		mysqli_close($connection);	
	?>
	</div>

</body>
</html>