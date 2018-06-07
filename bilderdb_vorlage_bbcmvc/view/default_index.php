<?php

foreach($galleries as $gallery) {
    echo "<div class='gallery'><a href='".$GLOBALS['appurl']."/Default/view?id=".$gallery->id."&gid=".$gallery->id."'><p>".$gallery->title."</p></a></div>";
}
