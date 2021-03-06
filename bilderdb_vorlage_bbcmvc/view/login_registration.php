<?php
/**
 * Login-Formular
 * Das Formular wird mithilfe des Formulargenerators erstellt.
 */
$lblClass = "col-md-2";
$eltClass = "col-md-4";
$btnClass = "btn btn-success";
$form = new Form($GLOBALS['appurl'] . "/login/registration");
$button = new ButtonBuilder();
echo $form->input()->label('E-Mail')->name('mail')->type('text')->lblClass($lblClass)->eltClass($eltClass);
echo $form->input()->label('Benutzername')->name('user')->type('text')->lblClass($lblClass)->eltClass($eltClass);
echo $form->input()->label('Passwort')->name('pw')->type('password')->lblClass($lblClass)->eltClass($eltClass);
echo $form->input()->label('Passwort wiederholen')->name('pw2')->type('password')->lblClass($lblClass)->eltClass($eltClass);
echo $button->start($lblClass, $eltClass);
echo $button->label('Login')->name('send')->type('submit')->class('btn-success');
echo $button->end();
echo $form->end();

if (isset($message)) {
    echo $message;
}
?>
