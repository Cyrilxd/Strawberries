<?php
require_once '../repository/LoginRepository.php';

/**
 * Controller für das Login und die Registration, siehe Dokumentation im DefaultController.
 */
class LoginController
{
    public function index()
    {
        $loginRepository = new LoginRepository();

        $view = new View('login_index');
        $view->title = 'Bilder-DB';
        $view->heading = 'Login';
        $message = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['mail'] != "") {
                $user = $_POST['mail'];

                if ($_POST['pw'] != "") {
                    $pw = $_POST['pw'];
                    $user = $loginRepository->login($user, $pw);

                    if (isset($user->id)) {
                        $_SESSION['uid'] = $user->id;
                        header("Location: /Strawberries/bilderdb_vorlage_bbcmvc");
                    }
                } else {
                    $message = $message . '<br>Bitte geben Sie ein Passwort ein';
                }
            }
            else {
                $message = $message . '<br>Bitte geben Sie eine Email ein';
            }
        }

        $view->message = $message;

        $view->display();
    }

    public function logout()
    {
        session_destroy();
        header("Location: /Strawberries/bilderdb_vorlage_bbcmvc");
    }


    /**
     * Zeigt das Registrations-Formular an
     * Dispatcher: /login/registration
     */
    public function registration()
    {
        $loginRepository = new LoginRepository();

        $message = "";
        $ok = true;
        $pw = "";
        $user = "";
        $mail= "";
        $pw2 = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            if (isset($_POST['user'])) {
                if ($_POST['user'] != "") {
                    $user = $_POST['user'];
                } else {
                    $ok = false;
                    $message = $message . "<br>Geben Sie bitte einen Benutzernamen ein";
                }
            }

            if (isset($_POST['mail'])) {
                if (!!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                    $mail = $_POST['mail'];
                } else {
                    $ok = false;
                    $message = $message . "<br>Geben Sie bitte eine gültige Email Adresse ein";
                }
            }

            if (isset($_POST['pw'])) {
                if ($_POST['pw'] != "") {
                    $pw = $_POST['pw'];
                    $uppercase = preg_match('@[A-Z]@', $pw);
                    $lowercase = preg_match('@[a-z]@', $pw);
                    $number    = preg_match('@[0-9]@', $pw);
                    if(!$uppercase || !$lowercase || !$number || strlen($pw) < 8) {
                        $message = $message . '<br>Das Passwort muss mindestens 8 Zeichen lang sein, ein Gross- und Kleinbuchstabe und eine Zahl enthalten';
                    }
                } else {
                    $ok = false;
                    $message = $message . "<br>Geben Sie bitte ein Passwort ein";
                }
            }

            if (isset($_POST['pw2'])) {
                if ($_POST['pw2'] != "") {
                    $pw2 = $_POST['pw2'];
                } else {
                    $ok = false;
                    $message = $message . "<br>Bitte wiederholen Sie das Passwort";
                }
            }


            if ($ok) {
                if ($pw == $pw2) {

                    $success = $loginRepository->register($user, $pw, $mail);
                    var_dump($success);
                    if (isset($success)) {
                        if($success != 0) {

                            session_start();
                            $_SESSION['uid'] = $success;
                            header("Location: /Strawberries/bilderdb_vorlage_bbcmvc");
                        }
                        else {
                            $message = $message . "<br> Es ist etwas schiefgelaufen!";
                        }
                    } else{
                        $message = $message . "<br> Es ist etwas schiefgelaufen!";
                    }
                } else {
                    $message = $message . "<br>Die Passwörter stimmen nicht überein";
                }
            }
        }

        $view = new View('login_registration');
        $view->title = 'Bilder-DB';
        $view->heading = 'Registration';

        $view->message = $message;

        $view->display();
    }


}

?>