<p><a href='<?= $GLOBALS['appurl'] ?>/gallery/addPicture?gid=<?= $_GET['id'] ?>'>Bild hinzufügen</a></p>

<?php

foreach($pictures as $picture) {
    echo "<a class='imgLink' href='".$GLOBALS['appurl']."/gallery/viewImage?id=".$picture->id."'><div class='gallery img'><p>".$picture->title."</p><img src='../../img.php?imgid=".$picture->thumbnailHash."' /></div></a>";
}
