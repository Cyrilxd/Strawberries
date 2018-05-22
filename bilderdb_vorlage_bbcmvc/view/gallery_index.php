<p><a href='<?= $GLOBALS['appurl'] ?>/gallery/createGallery'>Galerie hinzufügen</a></p>

<?php

foreach($galleries as $gallery) {
    echo "<div class='gallery'><a href='".$GLOBALS['appurl']."/gallery/view?id=".$gallery->id."&gid=".$gallery->id."'><p>".$gallery->title."</p></a></div>";
}
