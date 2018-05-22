<?php

$lblClass = "col-md-2";
$eltClass = "col-md-4";
$btnClass = "btn btn-success";
$form = new Form($GLOBALS['appurl'] . "/gallery/createGallery");
$button = new ButtonBuilder();
echo $form->input()->label('Name')->name('name')->type('text')->lblClass($lblClass)->eltClass($eltClass);
echo $form->input()->label('Beschreibung')->name('description')->type('text')->lblClass($lblClass)->eltClass($eltClass);
echo $form->input()->label('Öffentlich')->name('public')->type('checkbox')->value("yes")->lblClass($lblClass)->eltClass($eltClass);

echo $button->start($lblClass, $eltClass);
echo $button->label('Speichern')->name('send')->type('submit')->class('btn-success');
echo $button->end();
echo $form->end();

if($message != "") {
    echo $message;
}