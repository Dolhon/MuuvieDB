<?php
check_admin_login();
$target = basename($_SERVER['REQUEST_URI']);
$categories = get_all_categories();
	
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
<H2>$admin_views[$view]</H2>
<p>";

if (isset($_POST['submit']))
{
	$movie = array();
	$movie['id'] = $id;
	$movie['editDateTime'] = date("Y-m-d H:i:s");
	$movie['video'] = "";
	$movie['editUserId'] = "";
	$movie['text'] = "";
	$movie['name'] = "";
	$movie['editUserId'] = 1;			//TODO: myöhemmin ottaa sisäänkirjautuneen id
	$movie['categories'] = array();
	
	//check parameters
	if ((trim($_POST['name']) == "") OR (trim($_POST['text']) == "") OR
       (trim($_POST['video']) == "")) 
	{
	  echo "Fill all info.";
      exit;   
	} else if (!extract_youtube_id($_POST['video']))
	{
		echo "youtube link not correct";
		exit;  
	} else {
	if(isset($_POST['name'])) 
	{
			$movie['name'] = mysql_real_escape_string(trim($_POST['name']));
		}
		if(isset($_POST['text'])) 
		{
			$movie['text'] = mysql_real_escape_string(trim($_POST['text']));
		}
		if(isset($_POST['video'])) 
		{
			$link = $_POST['video'];
			$movie['video'] = extract_youtube_id($link);
		}
		
		//use later
		if(isset($_POST['file'])) {
			$file = $_POST['file'];
		}
		
		if(isset($_POST['categories'])) {
			if( is_array($_POST['categories']) ) {
				foreach ( $_POST['categories'] as $row ) {
					$movie['categories'][] = mysql_real_escape_string($row);
				}
			} else {
				$movie['categories'][] = mysql_real_escape_string($_POST['categories']);
			}
		}
	}
	
	edit_movie($movie);
	//upload_image($image);
	
	echo "movie updated";
	
}

$movie = get_movie($id);
$title = $movie['title'];
$video = $movie['video'];
$text = $movie['text'];
$dateTime = convert_datetime_to_view($movie['DateTime']);
if (file_exists("images/" . $id . ".jpg")) {
	$image = $id;
} else {
	$image = 0;
}
$author = $movie['author'];
$score = get_movie_rating($id);

$movie_categories = get_movie_categories($id);
$catNames = "";


echo "
<form action='$target' method='post'>

<table>	
	<tr>
		<th><a>Movie name</a></th>
		<td><input type='text' name='name' size='44' value='$title'></td>
	</tr>	
	<tr>
		<th><a>Description</a></th>
		<td><textarea rows='5' cols='35' name='text'>$text</textarea></td>
	</tr>
	<tr>
		<th><a>Youtube url</a></th>
		<td><input type='text' name='video' size='44' value='http://www.youtube.com/watch?v=$video'><br>
		<a>e.g:http://www.youtube.com/watch?v=xxxxxxxxxxx</a></td>
	</tr>
		<th><a>Categories</a></th>
		<td>
			<select multiple name='categories[]' size='6'>
		";
foreach ($categories as $row) {
	echo "<option value='" . $row['categoryID']. "' ";
	foreach ($movie_categories as $row2) {
		if ($row2['categoryID'] == $row['categoryID']) {
			echo "selected='selected'";
		}
	}
	
	echo "'>" . $row['catName'] . "</option>";
}
	echo "
	</select>
	</td>
	</tr>
	<tr>
		<th><a>Image</a></th>
		<td><input type='file' name='file' id='file'><br>
		<a>Only *.jpg</a></td>
	</tr>
	<tr>
		<th></th>
		<td><input type='submit' name='submit' value='Submit'></td>
	</tr>
</table>
</form>
</div><br><br>
";

/*
foreach ($columns as $column) {
	echo "	<tr>
				<th><a>$column</a></th>
				<td><a><input type='text' name='$column'></a></td>
			</tr>";
}
echo "

<div class='block'>
  <label>Movie name</label>
  <input type='text' name='name' size='44'>
</div>
<div class='block'>
  <label>Description</label>
  <textarea rows='5' cols='35' name='text'></textarea>
</div>
<div class='block'>
  <label>Youtube url</label>
  <input type='text' name='video' size='44'>
  <a>e.g:http://www.youtube.com/watch?v=C4kxS1ksqtw</a>
</div>
<div class='block'>
  <label>Image</label>
  <input type='file' name='file' id='file'>
</div>
<div class='block'>
  <label>1</label>
  <input type='submit' value='Add movie'>
</div>

<br><br><br><br><br><br><br><br><br>div.block{
  overflow:hidden;
  padding:3;
}
div.block label{
  width:160px;
  display:block;
  float:left;
  text-align:right;
  margin:5,5,5,5;
    padding:3;
}
div.block .input{
  margin-left:4px;
  float:left;
  padding:3;
}*/

?>
