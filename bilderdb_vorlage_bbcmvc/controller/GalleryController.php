<?php
require_once '../repository/GalleryRepository.php';

/**
 * Controller für das Login und die Registration, siehe Dokumentation im DefaultController.
 */
class GalleryController
{
    public function index()
    {
        if(is_null($_SESSION['uid'])) {
            header("Location: /Strawberries/bilderdb_vorlage_bbcmvc/public/");
        }
        unset($_SESSION['gid']);

        $db = new GalleryRepository();
        $galleries = $db->getYourGalleries();

        $view = new View('gallery_index');
        $view->galleries = $galleries;
        $view->title = 'Bilderdatenbank';
        $view->heading = 'Bilderdatenbank';
        $view->display();
    }

    public function createGallery()
    {
       if(is_null($_SESSION['uid'])) {
           header("Location: /Strawberries/bilderdb_vorlage_bbcmvc/public/");
       }
        $db = new GalleryRepository();
        $view = new View('gallery_createGallery');
        $view->title = 'Bilderdatenbank';
        $view->heading = 'Bilderdatenbank';
        $message = "";

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if($_POST['name'] != "") {
                $name = $_POST['name'];
                $description = $_POST['description'];
                $public = false;
                if($_POST['public'] == 'yes') {
                    $public = true;
                }

                $db->createGallery($name, $description, $public);
            }
            else {
                $message = $message."Eine Gallerie benötigt mindestens einen Namen";
            }
        }



        $view->message = $message;
        $view->display();
    }

    public function addPicture() {
        if(is_null($_SESSION['uid'])) {
            header("Location: /Strawberries/bilderdb_vorlage_bbcmvc/public/");
        }
        if(!isset($_SESSION['gid'])) {
            header("Location: /Strawberries/bilderdb_vorlage_bbcmvc/public/");
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {


            if ($_FILES['pic']['size'] == 0) {
                header("Location: /Strawberries/bilderdb_vorlage_bbcmvc/public/gallery/addGallery");
            }
            $imgHash = $this->randomName();
            $thumbHash = $this->randomName();
            var_dump($_FILES);
            @$fileObject1 = $_FILES["pic"];
            $path = "C:\\Pictures\\".$imgHash.".jpg";
            $path2 = "C:\\Pictures\\".$thumbHash.".jpg";
            move_uploaded_file($_FILES['pic']['tmp_name'], $path);
            $db = new GalleryRepository();
            $this->make_thumb($path, $path2, 300);

            $db->addImage( $imgHash, $thumbHash, preg_replace('/\.{1}[a-zA-Z]+$/','',$_FILES['pic']['name']), $_POST['description']);

            header("Location: /Strawberries/bilderdb_vorlage_bbcmvc/public/gallery/view?id=".$_SESSION['gid']);
        }

        $view = new View('gallery_addPicture');
        $view->title = 'Bilderdatenbank';
        $view->heading = 'Bilderdatenbank';
        $view->display();
    }

    public function view(){
        if(is_null($_SESSION['uid'])) {
            header("Location: /Strawberries/bilderdb_vorlage_bbcmvc/public/");
        }
        if(!isset($_GET['id'])) {
            header("Location: /Strawberries/bilderdb_vorlage_bbcmvc/public/gallery");
        }

        $_SESSION['gid'] = $_GET['id'];

        $db =  new GalleryRepository();
        $view = new View('gallery_view');
        $view->pictures=$db->pictureByGallery();
        $view->title = 'Bilderdatenbank';
        $view->heading = 'Bilderdatenbank';
        $view->display();


    }

    public function viewImage(){
        if(is_null($_SESSION['uid'])) {
            header("Location: /Strawberries/bilderdb_vorlage_bbcmvc/public/");
        }

        if(!isset($_GET['id'])) {
            header("Location: /Strawberries/bilderdb_vorlage_bbcmvc/public/");
        }
        $db = new GalleryRepository();
        $view = new View('gallery_view_single');

        $view->picture=$db->pictureById($_GET['id']);
        $view->title = 'Bilderdatenbank';
        $view->heading = 'Bilderdatenbank';
        $view->display();
    }

    function make_thumb($src, $dest, $desired_width) {

        /* read the source image */
        $source_image = imagecreatefromjpeg($src);
        $width = imagesx($source_image);
        $height = imagesy($source_image);

        /* find the "desired height" of this thumbnail, relative to the desired width  */
        $desired_height = floor($height * ($desired_width / $width));

        /* create a new, "virtual" image */
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

        /* copy source image at a resized size */
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

        /* create the physical thumbnail image to its destination */
        imagejpeg($virtual_image, $dest);
    }

    public function randomName() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 16; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


}