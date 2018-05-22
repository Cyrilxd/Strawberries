<?php
require_once '../lib/Repository.php';

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

        $statement->bind_param('issi', $_SESSION['uid'], $name, $description, $public);
        $statement->execute();

        return $conn->insert_id;
    }

    public function getYourGalleries()
    {
        $query = "SELECT * FROM {$this->galleryTableName} WHERE userId={$_SESSION['uid']}";

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
        $query = "SELECT * FROM {$this->pictureTableName} WHERE gid={$_SESSION['gid']}";

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
        $query = "INSERT INTO {$this->pictureTableName} (thumbnailHash, pictureHash, title, description, gid) VALUES (?,?,?,?,?);";

        $conn = ConnectionHandler::getConnection();
        $statement = $conn->prepare($query);

        $statement->bind_param('ssssi', $thumbnail, $img, $title, $description, $_SESSION['gid']);
        $statement->execute();

        return $conn->insert_id;
    }

    public function pictureById($id)
    {
        // Query erstellen
        $query = "SELECT * FROM {$this->pictureTableName} WHERE id=?";

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
/*
    public function deleteGallery($id)
    {
        $query = "DELETE FROM {$this->galleryTableName} WHERE id = ?";

        $conn = ConnectionHandler::getConnection();
        $statement = $conn->prepare($query);

        $statement->bind_param('ssssi', $thumbnail, $img, $title, $description, $_SESSION['gid']);
        $statement->execute();
    }

    public function deleteImage($id)
    {
        $query = "INSERT INTO {$this->pictureTableName} (thumbnailHash, pictureHash, title, description, gid) VALUES (?,?,?,?,?);";

        $conn = ConnectionHandler::getConnection();
        $statement = $conn->prepare($query);

        $statement->bind_param('ssssi', $thumbnail, $img, $title, $description, $_SESSION['gid']);
        $statement->execute();
    }*/
}
