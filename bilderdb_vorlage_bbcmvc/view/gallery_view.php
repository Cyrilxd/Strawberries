<p><a href='<?= $GLOBALS['appurl'] ?>/gallery/addPicture?gid=<?= $_GET['id'] ?>'>Bild hinzufügen</a></p>

<?php

foreach($pictures as $picture) {
    echo "<a class='imgLink'  onclick=\"showPicture('".$picture->pictureHash."','".$picture->ptitle."','".$picture->pdescription."')\"><div class='gallery img'><p>".$picture->ptitle."</p><img src='../../img.php?imgid=".$picture->thumbnailHash."' /><a class='delete' href='".$GLOBALS['appurl']."/gallery/deletePicture?id=".$picture->picId."'>Delete</a><a class='delete' href='".$GLOBALS['appurl']."/gallery/updatePicture?id=".$picture->picId."'>Update</a></div></a>";
}
?>

<div class="fullImage" >
    <div class="popupContainer">
        <div class="closePopup" onclick="closePopup()">X</div>
        <p id="title"></p>
        <img class='singleImage' id="img" />
        <p id="desc"></p>
    </div>
</div>

<script>
    function showPicture(hash, title, description) {
        $(".fullImage").css("display", "block");

        $("#title").text(title);
        $("#img").attr("src", "../../img.php?imgid=" + hash);
        $("#desc").text(description);
    }

    function closePopup() {
        $(".fullImage").css("display", "none");
    }
</script>