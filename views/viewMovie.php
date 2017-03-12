<?php
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

$rating = get_movie_rating($id);

echo "
<link rel='stylesheet' type='text/css' href='shadowbox/shadowbox.css'>
<script type='text/javascript' src='shadowbox/shadowbox.js'></script>
<script type='text/javascript'>
Shadowbox.init({
    handleOversize: 'drag',
	overlayOpacity: '0.9',
    modal: true
});
</script>
<div class='left'>
<img class='poster_big' src='images/" . $image . ".jpg' align='right'>
</div>
<div class='middle'>
<H2>" . $title . "</H2>
<p>
<iframe width='560' height='320' src='http://www.youtube.com/embed/" . $video . "' frameborder='0' allowfullscreen></iframe>
</p>
<p><a href='http://www.youtube.com/v/$video' title='$title' rel='shadowbox;width=900;height=560;player=swf'>Resize trailer</a><br>
Added: $dateTime Editor: $author <br>Category: ";

foreach($movie_categories as $row)
{
	echo "<a href='index.php?p=listMovies&cat=" . $row['categoryID'] . 
							"'>" . $row['catName'] . "</a>&nbsp;";
}
echo "<br>Rating: ";
draw_score_stars($rating);
echo "</p>
<p>
" . $text . "
</p>
</div>
<br>
<br>
";
?>