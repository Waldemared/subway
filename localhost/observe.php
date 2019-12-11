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
	$titleText = $lineIndex ? ($stationIndex ? "Обзор станции " : "Обзор линии " . $lineIndex) : "Обзор";
	$line = array();
	$lineQuery = "select name, path, color from line where id = $lineIndex";
	$lineResult = mysqli_query($connection, $lineQuery);
?>
<html>
<head>
	<meta http-equiv = "Content-Type" content ="text/html; charset=utf-8" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="/style/card.css">
	<link rel="stylesheet" type="text/css" href="/style/slideshow.css">
	<link rel="stylesheet" type="text/css" href="/style/footer.css">
	<link rel="stylesheet" type="text/css" href="/style/main.css">
	<link rel="stylesheet" type="text/css" href="/style/header.css">
	<script async src="/js/slideshow.js"></script>
	<title><?php echo $titleText; ?></title>
</head>
<body>
	<?php include('./header.php'); ?>
	<div class="content">
	<?php
		if ($lineResult != false && mysqli_num_rows($lineResult)) {
			$line = mysqli_fetch_assoc($lineResult);
			$line['stations'] = array();
			$stationQuery = "select * from station where line_id = $lineIndex order by position";
			$stationResult = mysqli_query($connection, $stationQuery);
			while ($stationRow = mysqli_fetch_assoc($stationResult)) {
				$line['stations'][$stationRow['position']] = $stationRow;
			}
			if ($line['stations'][$stationIndex] != null) {
				$station = $line['stations'][$stationIndex];

			echo "<div class=\"content_nav\">";
			if ($stationIndex >= 2) {
				echo "<a style=\"color: " . $line['color'] . ";\" href=\"/observe.php?line=" . $lineIndex  . "&station=" . ($station['position'] - 1) . "\">&#10094;&#10094;&#10094; " . $line['stations'][$stationIndex - 1]['name'] . "</a>   ";
			}
			echo $station['name'];
			if ($stationIndex < count($line['stations']))
			echo "<a style=\"color: " . $line['color'] . ";\" href=\"/observe.php?line=" . $lineIndex  . "&station=" . ($station['position'] + 1) . "\">" . $line['stations'][$stationIndex + 1]['name'] . " &#10095;&#10095;&#10095;</a>";
			echo "</div>";
			echo "<div class=\"description\">";
			echo "Станция: " . $station['name'] . "<br>";
			echo "Год основания: : " . $station['foundation_year'] . "<br>";
			echo "<a href=\"https://ru.wikipedia.org/wiki/" . $station['name'] . "_(станция_метро)\">Статья на Википедии</a> <br>";
			echo $station['description'];
			echo "</div>";
			echo "<div class=\"slideshow-container\">";

			$imageCount = 1;
			while (file_exists('./image/' . $line['path'] . '/' . $station['position'] . '_' . $imageCount . '.jpg')) {
				$imageCount++;
			}
			$imageCount--;

			
			for ($i = 1; $i <= $imageCount; $i++) {
				echo "<div class=\"mySlides fade\">
					    <div class=\"numbertext\">" . $i . "/" . $imageCount . "</div>
					    <img src=\"/image/" . $line['path'] . '/' . $station['position'] . '_' . $i . ".jpg\" style=\"width:100%\">
					  </div>";
			}
			echo "	  <a class=\"prev\" onclick=\"plusSlides(-1)\">&#10094;</a>
					  <a class=\"next\" onclick=\"plusSlides(1)\">&#10095;</a>
					</div>
					<br>

					<!-- The dots/circles -->
					<div style=\"text-align:center\">";
			for ($i = 1; $i <= $imageCount; $i++)
				echo "<span class=\"dot\" onclick=\"currentSlide(" . $i . ")\"></span>";
					  
				echo "</div>
					</div>";
	?>
			<script>

			</script>;

	<?php
					
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
		}
		mysqli_close($connection);	
	?>
	</div>
	<?php include('./footer.php'); ?>
</body>
</html>