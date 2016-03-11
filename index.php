<?php
	include("main.php");
	$games = getInfos();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<?php displayTable($games, "games");?>
</body>
</html>