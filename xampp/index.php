<?php
	if(file_get_contents("lang.tmp")=="")
	{
		header("Location: splash.php");	
		exit();
	}
?>
<html>
<head>
<meta name="author" content="Kai Oswald Seidler">
<meta http-equiv="cache-control" content="no-cache">
<?php include("lang/".file_get_contents("lang.tmp").".php"); ?>
<title>Testing <?php include('.version');?></title>
</head>
<body bgcolor=#ffffff>

</body>
</html>
