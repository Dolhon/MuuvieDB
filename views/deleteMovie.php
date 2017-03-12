<?php
check_admin_login();
$movie = get_movie($id);
$title = $movie['title'];
delete_movie($id);
echo "
<div class='left'>
</div>
<div class='middle'>
<H2>$admin_views[$view]</H2>
<p>
$title deleted.
</p>
<p>
<a href='index.php?p=adminMovies'>Back</a>
</p>
</div>
<br>
<br>";
?>