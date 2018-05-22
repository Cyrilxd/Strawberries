<?php

$lblClass = "col-md-2";
$eltClass = "col-md-4";
$btnClass = "btn btn-success";
$form = new Form($GLOBALS['appurl'] . "/gallery/addPicture", "POST", "multipart/form-data" );

echo $form->input()->label('Bild')->name('pic')->type('file')->lblClass($lblClass)->eltClass($eltClass);
echo $form->input()->label('Beschreibung')->name('description')->type('text')->lblClass($lblClass)->eltClass($eltClass);
$button = new ButtonBuilder();
echo $button->start($lblClass, $eltClass);
echo $button->label('Speichern')->name('send')->type('submit')->class('btn-success');
echo $button->end();
echo "</div></form>";