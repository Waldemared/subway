<?php
	header ("Content-Type: text/html; charset=utf-8");
	if ($_SESSION['lines'] == null)
		$_SESSION['lines'] = 'gf';
	echo $_SESSION['lines'];
?>

<?php
	$hostname = "127.0.0.1:3306";
	$username = "root";
	$password = "";
	$dbName = "subway";
?>
<html>
<head>
	<meta http-equiv = "Content-Type" content ="text/html; charset=utf-8" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="/style/card.css">
	<link rel="stylesheet" type="text/css" href="/style/main.css">
	<link rel="stylesheet" type="text/css" href="/style/header.css">
</head>
<body>
	<?php include('./header.php'); ?>
	<?php
		$connection = mysqli_connect($hostname,$username,$password) OR DIE ("Can't create a copnnection!");
		mysqli_select_db($connection, "$dbName") or die("Can't select a database!");
		mysqli_set_charset($connection, "utf8");
		$lineArray = array();
		print($lineArray);
		$lineQuery = "select * from line order by id";
		$lineResult = mysqli_query($connection, $lineQuery);
		while ($lineRow = mysqli_fetch_assoc($lineResult)) {
			$lineId = $lineRow["id"];
			$lineName = $lineRow["name"];
			$linePath = $lineRow["path"];
			$lineArray[$lineId] = $lineRow;
			echo "<ul>";
			echo "$lineId линия. $lineName";
			$stationQuery = "select * from station where line_id = $lineId order by position";
			$stationResult = mysqli_query($connection, $stationQuery);
			while ($stationRow = mysqli_fetch_assoc($stationResult)) {
				$stationPath = $stationRow["path"];
				$stationName = $stationRow["name"];
				$stationPosition = $stationRow["position"];
				$stationFY = $stationRow["foundation_year"];
				$lineArray[$lineId]['stations'][$stationPosition] = $stationRow;
				echo "<li><a href=\"/line$lineId/$stationPath\">
					$stationPosition - $stationName
				</a></li>";
			}
			echo "</ul>";
		}
		echo "<pre>";
		print_r($lineArray);
		echo "</pre>";



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
</body>
</html>