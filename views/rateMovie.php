<?php
check_admin_login();
$target = basename($_SERVER['REQUEST_URI']);
$movie = get_movie($id);
$title = $movie['title'];
echo "
<div class='left'>";

//admin linkit
echo"<p>
<ul><h4>Admin menu</h4>";
foreach ($admin_views as $admin_menu_view => $admin_menu_text) {
	echo "<li><a href='index.php?p=$admin_menu_view'>$admin_menu_text</a></li>";
}
echo "</ul></p>";

echo "
</div>
<div class='middle'>
<H2>$admin_views[$view] - $title</H2>
<p>";

if (isset($_POST['submit']))
{
	$movie_rating = array();
	$movie_rating['userID'] = "";
	$movie_rating['userID'] = "1";  //TEMP
	$movie_rating['rating'] = "3";
	$movie_rating['movieID'] = $id;
	
	//check parameters
	if (trim($_POST['rating']) == "")
	{
		echo "Fill all info.";
		exit;     
	} else if(isset($_POST['rating'])) 
	{
		$movie_rating['rating'] = $_POST['rating'];
	}
	
	rate_movie($movie_rating);
	
	echo "movie rated";
	
}
if (isset($_GET['rating']))
{
	$movie_rating = array();
	$movie_rating['userID'] = "";
	$movie_rating['userID'] = "1";  //TEMP
	$movie_rating['rating'] = "3";
	$movie_rating['movieID'] = $id;
	
	//check parameters
	if (trim($_GET['rating']) == "")
	{
		echo "Fill all info.";
		exit;     
	} else if(isset($_GET['rating'])) 
	{
		$movie_rating['rating'] = $_GET['rating'];
	}
	
	rate_movie($movie_rating);
	
	echo "movie rated";
	
}

echo "
<form action='$target' method='post'>

<table>	
	<tr>
		<th><a>Movie rating</a></th>
		<td>
			<div id='movie_rating'>
				<a href='$target&rating=1'><img id='star1' src='images/star_off.png' /></a>
				<a href='$target&rating=2'><img id='star2' src='images/star_off.png' /></a>
				<a href='$target&rating=3'><img id='star3' src='images/star_off.png' /></a>
				<a href='$target&rating=4'><img id='star4' src='images/star_off.png' /></a>
				<a href='$target&rating=5'><img id='star5' src='images/star_off.png' /></a>
			</div>
		</td>
	</tr>	
	<tr>
		<th><a>Movie rating</a></th>
		<td>
		<select name='rating'>
			<option value='1'>1</option>
			<option value='2'>2</option>
			<option value='3'>3</option>
			<option value='4'>4</option>
			<option value='5'>5</option>
		</select>
		</td>
	</tr>	
	<tr>
		<th></th>
		<td><input type='submit' name='submit' value='Submit'></td>
	</tr>
</table>
</form>
</div><br><br>
<script>
star1.onmouseout = function () {
    this.src = 'images/star_off.png';
};
star1.onmouseover = function () {
    this.src = 'images/star_on.png';
};
star2.onmouseover = function () {
	star1.src = 'images/star_on.png';
    this.src = 'images/star_on.png';
};
star2.onmouseout = function () {
	star1.src='images/star_off.png';
    this.src = 'images/star_off.png';
};
star3.onmouseover = function () {
	star1.src = 'images/star_on.png';
	star2.src = 'images/star_on.png';
    this.src = 'images/star_on.png';
};
star3.onmouseout = function () {
	star1.src='images/star_off.png';
	star2.src='images/star_off.png';
    this.src = 'images/star_off.png';
};
star4.onmouseover = function () {
	star1.src = 'images/star_on.png';
	star2.src = 'images/star_on.png';
	star3.src = 'images/star_on.png';
    this.src = 'images/star_on.png';
};
star4.onmouseout = function () {
	star1.src='images/star_off.png';
	star2.src='images/star_off.png';
	star3.src='images/star_off.png';
    this.src = 'images/star_off.png';
};
star5.onmouseover = function () {
	star1.src = 'images/star_on.png';
	star2.src = 'images/star_on.png';
	star3.src = 'images/star_on.png';
	star4.src = 'images/star_on.png';
    this.src = 'images/star_on.png';
};
star5.onmouseout = function () {
	star1.src='images/star_off.png';
	star2.src='images/star_off.png';
	star3.src='images/star_off.png';
	star4.src='images/star_off.png';
    this.src = 'images/star_off.png';
};
</script>
";
?>