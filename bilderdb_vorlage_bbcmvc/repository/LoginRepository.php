<?php
require_once '../lib/Repository.php';
/**
 * Datenbankschnittstelle für die Benutzer
 */
  class LoginRepository extends Repository
  {
      protected $tableName = "user";

      public function login($user, $pw) {

          $query = "SELECT * FROM {$this->tableName} WHERE username = ? AND password = ?";


          $statement = ConnectionHandler::getConnection()->prepare($query);

          $statement->bind_param('ss', $user, $pw);
          $statement->execute();
          $result = $statement->get_result();

          if (!$result) {
              throw new Exception($statement->error);
          }

          $row = $result->fetch_object();
          $result->close();

          return $row;
    }
  }
?>