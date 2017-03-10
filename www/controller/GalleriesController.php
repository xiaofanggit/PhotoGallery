<?php

/**
 * Created by PhpStorm.
 * User: xiaof
 * Date: 2017-03-09
 * Time: 5:01 PM
 */
class GalleriesController extends Controller
{
    /**
     * GalleriesController constructor.
     * No login users could see the display page
     */
    function __construct()
    {
        if ((!isset($_SESSION) || empty($_SESSION['userId'])) && $_SERVER['PHP_SELF'] !== '/Galleries/display') {
            $this->redirect('Users/Login');

        }
    }

    /**
     * Display all galleries and their photos
     * http://localhost:8888/Galleries/display
     */
    public function display()
    {
        $galleries = [];
        if (file_exists('www/resources/user1'.'-galleries.json')) {
            $jsonString = file_get_contents('www/resources/user1-galleries.json');
            $galleries = Helper::convertJsonStrToArray($jsonString);
        }
        if (file_exists('www/resources/user1-photos.json')) {
            $jsonString = file_get_contents('www/resources/user1-photos.json');
            $photos = Helper::convertJsonStrToArray($jsonString);

            $galleryPhotos = Helper::getGalleryPhotos($photos);
        }
        require_once VIEW . 'list.galleries.html.php';
    }

    /**
     * Login user can create, edit and delete galleries here.
     * Also can upload photos, and delete photos.
     * http://localhost:8888/Galleries/manager
     */
    public function manager()
    {
        $galleries = [];
        if (file_exists('www/resources/user'.$_SESSION['userId'].'-galleries.json')) {
            $jsonString = file_get_contents('www/resources/user'.$_SESSION['userId'].'-galleries.json');
            $galleries = Helper::convertJsonStrToArray($jsonString);
        }
        if (file_exists('www/resources/user'.$_SESSION['userId'].'-photos.json')) {
            $jsonString = file_get_contents('www/resources/user'.$_SESSION['userId'].'-photos.json');
            $photos = Helper::convertJsonStrToArray($jsonString);

            $galleryPhotos = Helper::getGalleryPhotos($photos);
        }
        require_once VIEW . 'manager.galleries.html.php';
    }

    /**
     * Upload photos
     */
    public function uploadPhoto(){
        $data = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data['id'] = $_REQUEST['id'];
            $data['galleryId'] = $_REQUEST['galleryId'];

            $response = Helper::uploadPhoto();

            if (!isset($response['fail'])) {
                $data['path'] = $response['path'];
                $data['photoName'] = $response['photoName'];
                $json_data = json_encode($data);
                file_put_contents('www/resources/user' . $_SESSION['userId'] . '-photos.json', $json_data, FILE_APPEND);

            }
        }
        $this->redirect('/Galleries/manager');
    }

    /**
     * Create a new gallery
     */
    public function addGallery()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data['id'] = $_REQUEST['id'];
            $data['userId'] = $_SESSION['userId'];
            $data['galleryTitle'] = $_REQUEST['galleryTitle'];
            $data['galleryDescription'] = $_REQUEST['galleryDescription'];

            $json_data = json_encode($data);
            file_put_contents('www/resources/user'.$_SESSION['userId'].'-galleries.json', $json_data, FILE_APPEND);
            $this->redirect('/Galleries/manager');
        }
    }

    /**
     * edit an existed gallery
     * @param int $id gallery id
     */
    public function editGallery()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data['id'] = $_REQUEST['id'];
            if (!empty($data['id'])) {
                $data['userId'] = $_SESSION['userId'];
                $data['galleryTitle'] = $_REQUEST['galleryTitle'];
                $data['galleryDescription'] = $_REQUEST['galleryDescription'];
                $jsonString = file_get_contents('www/resources/user'.$_SESSION['userId'].'-galleries.json');
                $results = Helper::convertJsonStrToArray($jsonString);
                $galleryKey = Helper::searchById($data['id'], $results);
                $results[$galleryKey] = $data;
                $jsonData = json_encode($results);
                file_put_contents('www/resources/user'.$_SESSION['userId'].'-galleries.json', $jsonData);
            }
            $this->redirect('/Galleries/manager');
        }

    }

    /**
     *  Delete a gallery
     * @param int $id: gallery id
     */
    public function deleteGallery($id)
    {
        $galleryId = !empty($id[0]) ? $id[0] : '';
        if (!empty($galleryId)) {
            //Delete gallery
            Helper::deleteJsonData('www/resources/user'.$_SESSION['userId'].'-galleries.json', 'id', $galleryId);

            //Delete photos
            Helper::deleteJsonData('www/resources/user'.$_SESSION['userId'].'-photos.json', 'galleryId', $id);
        }
        $this->redirect('/Galleries/manager');

    }

    /**
     * Delete a photo
     * @param int $id: photo id
     */
    public function deletePhoto($id)
    {
        $photoId = !empty($id[0]) ? $id[0] : '';
        if (!empty($photoId)) {
            Helper::deleteJsonData('www/resources/user'.$_SESSION['userId'].'-photos.json', 'id', $photoId);
        }
        $this->redirect('/Galleries/manager');
    }
}