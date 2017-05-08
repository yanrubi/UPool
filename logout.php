<?php
	session_unset();
	$page = <<<PAGE
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Logging out</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="search.css">
		<meta http-equiv="refresh" content="3;url=main.html" />
	</head>
	
	<body>
	Logged out succesfully
	</body>
</html>
PAGE;
	echo $page;
?>