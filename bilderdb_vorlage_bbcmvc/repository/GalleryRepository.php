<?php
require_once '../lib/Repository.php';
require_once '../repository/LoginRepository.php';

/**
 * Datenbankschnittstelle für die Benutzer
 */
class GalleryRepository extends Repository
{
    protected $galleryTableName = "gallery";
    protected $pictureTableName = "picture";

    public function createGallery($name, $description, $public)
    {
        $query = "INSERT INTO {$this->galleryTableName} (userId, title, description, publicGallery) VALUES (?,?,?,?);";


        $conn = ConnectionHandler::getConnection();
        $statement = $conn->prepare($query);

        $statement->bind_param('issi', $_SESSION['uid'], htmlspecialchars($name), htmlspecialchars($description), $public);
        $statement->execute();

        return $conn->insert_id;
    }

    public function getYourGalleries()
    {
        $loginConn = new LoginRepository();
        $admin = $loginConn->currentUserIsAdmin();
        if($admin != 1) {
            $query = "SELECT * FROM {$this->galleryTableName} WHERE userId={$_SESSION['uid']}";
        }
        else {
            $query = "SELECT * FROM {$this->galleryTableName}";
        }


        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->execute();

        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }

        // Datensätze aus dem Resultat holen und in das Array $rows speichern
        $rows = array();
        while ($row = $result->fetch_object()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function pictureByGallery () {
        $lconn = new LoginRepository();
        $admin = $lconn->currentUserIsAdmin();

        $query = "SELECT * FROM picture as p JOIN gallery as g on g.id=p.gid JOIN user as u on g.userId=u.id where p.gid={$_SESSION['gid']} AND u.id={$_SESSION['uid']}";

        if($admin == 1) {
            $query = "SELECT * FROM picture where gid={$_SESSION['gid']}";
        }
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->execute();

        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }

        // Datensätze aus dem Resultat holen und in das Array $rows speichern
        $rows = array();
        while ($row = $result->fetch_object()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function addImage($img, $thumbnail, $title, $description)
    {
        $query = "INSERT INTO {$this->pictureTableName} (thumbnailHash, pictureHash, ptitle, pdescription, gid) VALUES (?,?,?,?,?);";

        $conn = ConnectionHandler::getConnection();
        $statement = $conn->prepare($query);

        $statement->bind_param('ssssi', $thumbnail, $img, htmlspecialchars($title), htmlspecialchars($description), $_SESSION['gid']);
        $statement->execute();

        return $conn->insert_id;
    }

    public function pictureById($id)
    {

        $lconn = new LoginRepository();
        $admin = $lconn->currentUserIsAdmin();


        // Query erstellen
        $query = "SELECT * FROM picture as p JOIN gallery as g on g.id=p.gid JOIN user as u on g.userId=u.id where p.picId=? AND u.id={$_SESSION['uid']}";

        if($admin == 1) {
            $query = "SELECT * FROM picture where picId=?";
        }
        // Datenbankverbindung anfordern und, das Query "preparen" (vorbereiten)
        // und die Parameter "binden"
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i', $id);

        // Das Statement absetzen
        $statement->execute();

        // Resultat der Abfrage holen
        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }

        // Ersten Datensatz aus dem Reultat holen
        $row = $result->fetch_object();

        // Datenbankressourcen wieder freigeben
        $result->close();

        // Den gefundenen Datensatz zurückgeben
        return $row;
    }

    public function galleryById($id)
    {
        // Query erstellen
        $query = "SELECT * FROM {$this->galleryTableName} WHERE id=?";

        // Datenbankverbindung anfordern und, das Query "preparen" (vorbereiten)
        // und die Parameter "binden"
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i', $id);

        // Das Statement absetzen
        $statement->execute();

        // Resultat der Abfrage holen
        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }

        // Ersten Datensatz aus dem Reultat holen
        $row = $result->fetch_object();

        // Datenbankressourcen wieder freigeben
        $result->close();

        // Den gefundenen Datensatz zurückgeben
        return $row;
    }

    public function deleteGallery($id)
    {
        $_SESSION['gid'] = $id;
        $data = $this->pictureByGallery();
        foreach($data as $d) {
            $this->deleteImage($d->id);
        }
        $conn = ConnectionHandler::getConnection();

        $query = "DELETE FROM {$this->galleryTableName} WHERE id = ?";

        $statement = $conn->prepare($query);

        $statement->bind_param('i', $id);
        $statement->execute();
    }

    public function deleteImage($id)
    {
        $data = $this->pictureById($id);
        unlink("C:\\Pictures\\".$data->pictureHash.".jpg");
        unlink("C:\\Pictures\\".$data->thumbnailHash.".jpg");

        $query = "DELETE FROM {$this->pictureTableName} WHERE picId = ?";

        $conn = ConnectionHandler::getConnection();
        $statement = $conn->prepare($query);

        $statement->bind_param('i', $id);
        $statement->execute();
    }

    public function updateImage($id, $title, $description) {
        $query = "UPDATE {$this->pictureTableName} SET ptitle = ?, pdescription = ? where picId = ?";

        $conn = ConnectionHandler::getConnection();
        $statement = $conn->prepare($query);

        $statement->bind_param('ssi', htmlspecialchars($title), htmlspecialchars($description), $id);
        $statement->execute();
    }

    public function updateGallery($id, $title, $description, $public) {
        $query = "UPDATE {$this->galleryTableName} SET title = ?, description = ?, publicGallery = ? where id = ?";

        $conn = ConnectionHandler::getConnection();
        $statement = $conn->prepare($query);

        $statement->bind_param('sssi', htmlspecialchars($title), htmlspecialchars($description), $public, $id);
        $statement->execute();
    }

    public function getPublicGalleries() {

        $query = "SELECT * FROM {$this->galleryTableName} where publicGallery=1";



        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->execute();

        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }

        // Datensätze aus dem Resultat holen und in das Array $rows speichern
        $rows = array();
        while ($row = $result->fetch_object()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function getPublicPictures() {

        $query = "SELECT * FROM picture as p JOIN gallery as g on g.id=p.gid where p.gid={$_SESSION['gid']} AND g.publicGallery=1";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->execute();

        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }

        // Datensätze aus dem Resultat holen und in das Array $rows speichern
        $rows = array();
        while ($row = $result->fetch_object()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function publicPictureById($id) {
        // Query erstellen
        $query = "SELECT * FROM picture as p JOIN gallery as g on g.id=p.gid where p.picId=? AND g.publicGallery=1";

        // Datenbankverbindung anfordern und, das Query "preparen" (vorbereiten)
        // und die Parameter "binden"
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i', $id);

        // Das Statement absetzen
        $statement->execute();

        // Resultat der Abfrage holen
        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }

        // Ersten Datensatz aus dem Reultat holen
        $row = $result->fetch_object();

        // Datenbankressourcen wieder freigeben
        $result->close();

        // Den gefundenen Datensatz zurückgeben
        return $row;

    }


}
