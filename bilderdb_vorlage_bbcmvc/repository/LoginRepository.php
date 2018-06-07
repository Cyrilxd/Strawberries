<?php
require_once '../lib/Repository.php';



/**
 * Datenbankschnittstelle für die Benutzer
 */
class LoginRepository extends Repository
{
    protected $tableName = "user";
    protected $salt = "imasaltandineed22chars";

    public function login($user, $pw)
    {

        $query = "SELECT * FROM {$this->tableName} WHERE mail = ? AND password = ?";


        $statement = ConnectionHandler::getConnection()->prepare($query);
        $dbpw = password_hash(htmlspecialchars($pw), PASSWORD_DEFAULT,array('salt' => $this->salt));
        var_dump($dbpw);
        $statement->bind_param('ss', $user, $dbpw);
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

        $statement->bind_param('sss', htmlspecialchars($user), password_hash(htmlspecialchars($pw), PASSWORD_DEFAULT,array('salt' => $this->salt)), htmlspecialchars($mail));
        $statement->execute();

        return $conn->insert_id;
    }

    public function currentUserIsAdmin() {
        if(is_null($_SESSION['uid'])) {
            return 0;
        }

        $query = "SELECT * FROM {$this->tableName} WHERE id=?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i', $_SESSION['uid']);

        $statement->execute();

        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }

        $row = $result->fetch_object();

        $result->close();

        if($row->isAdmin == 1) {
            return 1;
        }

        return 0;
    }
}

?>