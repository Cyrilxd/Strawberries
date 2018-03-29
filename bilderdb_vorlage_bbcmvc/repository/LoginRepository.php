<?php
require_once '../lib/Repository.php';

/**
 * Datenbankschnittstelle für die Benutzer
 */
class LoginRepository extends Repository
{
    protected $tableName = "user";

    public function login($user, $pw)
    {

        $query = "SELECT * FROM {$this->tableName} WHERE mail = ? AND password = ?";


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

    public function register($user, $pw, $mail)
    {

        $query = "INSERT INTO {$this->tableName} (username, password, mail) VALUES (?,?,?);";


        $conn = ConnectionHandler::getConnection();
        $statement = $conn->prepare($query);

        $statement->bind_param('sss', $user, $pw, $mail);
        $statement->execute();

        return $conn->insert_id;
    }
}

?>