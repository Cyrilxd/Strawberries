<?php


foreach($pictures as $picture) {
    echo "<a class='imgLink' onclick=\"showPicture('".$picture->pictureHash."','".$picture->title."','".$picture->description."')\"><div class='gallery img'><p>".$picture->title."</p><img src='../../img.php?imgid=".$picture->thumbnailHash."' /></div></a>";
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
