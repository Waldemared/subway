<?php
	header ("Content-Type: text/html; charset=utf-8");
	echo $_SESSION['lines'];
?>

<?php
	$hostname = "127.0.0.1:3306";
	$username = "root";
	$password = "";
	$dbName = "subway";
	$connection = mysqli_connect($hostname,$username,$password) OR DIE ("Can't create a copnnection!");
		mysqli_select_db($connection, "$dbName") or die("Can't select a database!");
		mysqli_set_charset($connection, "utf8");
	$lineIndex = $_GET['line'];
	$stationIndex = $_GET['station'];
	$line = array();
	$lineQuery = "select name, path from line where id = $lineIndex";
	$lineResult = mysqli_query($connection, $lineQuery);
?>
<html>
<head>
	<meta http-equiv = "Content-Type" content ="text/html; charset=utf-8" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="/style/card.css">
	<link rel="stylesheet" type="text/css" href="/style/main.css">
	<link rel="stylesheet" type="text/css" href="/style/header.css">
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
		if ($lineResult != false && mysqli_num_rows($lineResult)) {
			$lineRow = mysqli_fetch_assoc($lineResult);
			$line['id'] = $lineIndex;
			$line['name'] = $lineRow['name'];
			$line['path'] = $lineRow['path'];
			$line['stations'] = array();
			$stationQuery = "select * from station where line_id = $lineIndex order by position";
			$stationResult = mysqli_query($connection, $stationQuery);
			while ($stationRow = mysqli_fetch_assoc($stationResult)) {
				$line['stations'][$stationRow['position']] = $stationRow;
			}
			if ($line['stations'][$stationIndex] != null) {
				$station = $line['stations'][$stationIndex];

				echo "Станция: " . $station['name'] . "<br>";
				echo "Год основания: : " . $station['foundation_year'] . "<br>";

				if ($stationIndex >= 2) {
					echo "<a href=\"/observe.php?line=" . $lineIndex  . "&station=" . ($station['position'] - 1) . "\">Предыдущая станция: " . $line['stations'][$stationIndex - 1]['name'] . "</a>   ";
				}

				echo $station['name'];

				if ($stationIndex < count($line['stations']))
				echo "   <a href=\"/observe.php?line=" . $lineIndex  . "&station=" . ($station['position'] + 1) . "\">Следующая станция: " . $line['stations'][$stationIndex + 1]['name'] . "</a>";
			} else {
				$tempStation = $line['stations'][$i];
				echo "<div class=\"card_container\">";
				for ($i = 1; $i <= count($line['stations']); $i++) {
					echo "<div class=\"card\">
					<a href=\"/observe.php?line=" . $lineIndex . "&station=" . $i . "\">
					<img src=\"/image/" . $line['path'] . "/" . $i . "_main.jpg\">
						</a>
					<div class=\"card_content\">
    					<h4><b>" . $line['stations'][$i]['name'] . "</b></h4>
  					</div></div>";
				}
				echo "</div>";
			}


			if (true) {
				echo "<pre>";
				print_r($line);
				echo "</pre>";
			}
		} else {
			echo "<div class=\"card_container\">";
			$lineArray = array();
			$lineQuery = "select * from line order by id";
			$lineResult = mysqli_query($connection, $lineQuery);
			while ($lineRow = mysqli_fetch_assoc($lineResult)) {
				$lineId = $lineRow["id"];
				$lineName = $lineRow["name"];
				$linePath = $lineRow["path"];
				$line_stations_num_query = "select count(position) as station_count from station where line_id = $lineId";
				$line_stations_num_result = mysqli_query($connection, $line_stations_num_query);
				$line_stations_count = mysqli_fetch_assoc($line_stations_num_result)["station_count"];
				$lineArray[$lineId] = $lineRow;

				echo "<div class=\"card\">
				<a href=\"/observe.php?line=" . $lineId . "\">
				<img src=\"/image/" . $linePath . "/" . random_int(1, $line_stations_count) . "_main.jpg\">
					</a>
				<div class=\"card_content\">
					<h4><b>" . $lineName . "</b></h4>
					</div></div>";
			}
			echo "</div>";
			echo "<pre>";
			print_r($lineArray);
			echo "</pre>";
		}
		mysqli_close($connection);	
	?>
	</div>

</body>
</html>