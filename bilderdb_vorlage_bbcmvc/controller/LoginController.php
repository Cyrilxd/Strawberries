<?php
require_once '../repository/LoginRepository.php';
/**
 * Controller für das Login und die Registration, siehe Dokumentation im DefaultController.
 */
  class LoginController
  {
    /**
     * Default-Seite für das Login: Zeigt das Login-Formular an
	 * Dispatcher: /login
     */
    public function index()
    {
      $loginRepository = new LoginRepository();
      $view = new View('login_index');
      $view->title = 'Bilder-DB';
      $view->heading = 'Login';
      $message = "";

      if(isset($_POST['user'])) {
        $user = $_POST['user'];

        if(isset($_POST['pw'])) {
            $pw = $_POST['pw'];

            $userid = $loginRepository->login($user, $pw);
            if(isset($userid)) {
                $message = $message + $userid;
            }
        }
        else {
            $message =  $message + '<br>';
        }
       }

      $view->display();
    }



    /**
     * Zeigt das Registrations-Formular an
	 * Dispatcher: /login/registration
     */
    public function registration()
    {
      $view = new View('login_registration');
      $view->title = 'Bilder-DB';
      $view->heading = 'Registration';
      $view->display();
    }
}
?>