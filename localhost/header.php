<?php
	$linesRes = mysqli_query($connection, "select name, color, id from line order by id");
?>
<div class="header">
<ul>
  <li><a href="/observe.php">Главная</a></li>
  <?php
  	  while($lineRow = mysqli_fetch_assoc($linesRes)) {
  	  	echo "<li><a href=\"/observe.php?line=" . $lineRow['id'] . "\" style=\"color: " . $lineRow['color'] . "\">" . $lineRow['name'] . "</a></li>";
  	  }
  ?>
  <li><a href="http://www.metro.spb.ru/map/route.html" target="_blank">Интерактивная навигация</a></li>
  <li style="float: right;">
  	<form action="search.php">
  		<input type="text" name="name" placeholder="Введите строку">
  		<button type="submit"></button>
  </form>
</li>
</ul>
	  
</div>
