
<div class="fullImage">
<?php

echo "<p>".$picture->title."</p>";
echo "<img class='singleImage' src='../../img.php?imgid=".$picture->pictureHash."' />";
echo $picture->description;

?>

</div>
