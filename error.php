<?php

if(!isset($error)) exit();

?>

<!DOCTYPE html>
<html lang="en">
<head>

	<title>Error!</title>
	<link rel="stylesheet" href="css/style.css" type="text/css" />

</head>
<body>

	<div class="error_wrapper">
		<div class="error"><?php echo $error; ?></div>
	</div>

</body>
</html>