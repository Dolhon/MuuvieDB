 <?php
if(isset($_SESSION['Login']) && $_SESSION['Login'] == 'TRUE'){
		header('Location: index.php?p=adminMovies');
}
 echo "
<div class='left'>
</div>
<div class='middle'>
<H2>Login</H2>
<p>";

 if(isset($_POST['password']) && isset($_POST['password'])) {
	$user = $_POST['user'];
	$pass = $_POST['password'];
	login($user, $pass);
}

echo "
<form method='post' action='http://" . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] . "'>
	<p>Username: <input type='text' name='user' /></p>
	<p>Passoword: <input type='password' name='password' /></p>
	<p><input type='submit' value='Submit' /></p>
	</form>
</p>
</div>
<br>
<br>";
?>