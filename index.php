<?php
	include("main.php");

	if (isset($_GET['date'])) {

		$date = str_replace(".", "%2F", $_GET['date']);
	} else {

		$date = date("d%2Fm%2FY");
	}

	$games = getInfos($date);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<form action="/" method="GET">
		Date (dd.mm.YYYY) : <input type="text" name="date" id="" value="<?php echo $_GET['date'];?>">
		<input type="submit" value="Ok">
	</form>
	<br>
	<?php displayTable($games, "games");?>
</body>
</html>