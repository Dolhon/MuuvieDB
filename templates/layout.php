<?php
echo "
<!DOCTYPE html>
<head>
<title>$website_name - ";
if ($security_level == "admin") {
	echo $admin_views[$view];
} else {
	echo $views[$view];
}
echo "
</title>
<link href='css/style.css' rel='stylesheet' type='text/css' />
</head>

<body>

<br>
<div class='container' >
<!-- header template -->";
include('templates/header.php');
echo "
<!-- view -->";
require_once("views/" . $view . ".php");
echo "
<div class='footer'>
<a>Copyright &copy; $website_name 2014</a>
</div>";
echo "
</div>
</body>
</html>";
?>