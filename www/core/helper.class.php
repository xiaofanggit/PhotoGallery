<?php

/**
 * Created by PhpStorm.
 * User: xiaof
 * Date: 2017-03-10
 * Time: 8:30 AM
 */
class Helper
{
    /**
     * Create a folder using y,m, and d
     * @return string directory name
     */
    public static function createOrGetDateFolder()
    {
        $year = date("Y");
        $month = date("m");
        $day = date("d");

        //The folder path: YYYY/MM/DD
        $directory = "$year/$month/$day/";

        //If the directory doesn't already exists.
        $fullDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $directory;
        if (!is_dir($fullDir)) {
            mkdir($fullDir, 755, true);
        }
        return $directory;
    }

    /**
     * Handler converting json string into multiple dimension arrays
     * @param $jsonStr
     * @return array
     */
    public static function convertJsonStrToArray($jsonStr)
    {
        $jsonStr = str_replace(array('[{', '}]', '[{}]'), '', $jsonStr);
        $jsonStr = str_replace(array('},{'), '}{', $jsonStr);
        $jsonArr = explode('}{', $jsonStr);

        $results = array();
        if (empty($jsonArr[0])){return null;}
        foreach ($jsonArr as $arr) {
            $arr = str_replace(array('{', '}'), '', $arr);
            $results[] = !empty($arr) ? json_decode('{' . $arr . '}') : '';
        }
        return $results;
    }

    /**
     * Search id from the array
     * @param $id
     * @param $array
     * @return int|null|string
     */
    public static function searchById($id, $array)
    {
        foreach ($array as $key => $val) {
            if (empty($val->id)){continue;}
            if (!empty($val->id) && $val->id == $id) {
                return $key;
            }
        }
        return null;
    }

    /**
     * Search galleryId from array
     * @param $id
     * @param $array
     * @return int|null|string
     */
    public static function searchByKey($id, $array)
    {
        foreach ($array as $key => $val) {
            if (!empty($val->galaryId) && $val->galaryId == $id) {
                return $key;
            }
        }
        return null;
    }

    /**
     * Upload array
     * @return array, success or fail information
     */
    public static function uploadPhoto()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $name = $_FILES['file']['name'];
            $tmpName = $_FILES['file']['tmp_name'];
            $error = $_FILES['file']['error'];
            $size = $_FILES['file']['size'];
            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $name = $_FILES['file']['name'];
                $tmpName = $_FILES['file']['tmp_name'];
                $error = $_FILES['file']['error'];
                $size = $_FILES['file']['size'];
                $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                $response = '';
                if ($error == UPLOAD_ERR_OK) {
                    $valid = true;
                    //validate file extensions
                    if (!in_array($ext, array('jpg', 'jpeg', 'png', 'gif'))) {
                        $valid = false;
                        $response = 'Invalid file extension.';
                    }
                    //validate file size
                    if ($size > 2 * 1024 * 1024) {
                        $valid = false;
                        $response = 'File size is exceeding maximum allowed size.';
                    }
                    //upload file
                    if ($valid) {
                        $directory = Helper::createOrGetDateFolder();
                        $name = uniqid() . '.' . $ext;
                        $targetPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR . $name;
                        move_uploaded_file($tmpName, $targetPath);
                        return array(
                            'path' => 'www' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR,
                            'photoName' => $name
                        );
                    }
                    return array('fail' => true, 'response' => $response);
                }
                return array('fail' => true, 'response' => $response);
            }
        }
    }

    /**
     * Get all photos of a gallery
     * @param $photos
     * @return array|null
     */
    public function getGalleryPhotos($photos)
    {
        if (empty($photos)) {
            return null;
        }
        $galleryPhotos = array();
        foreach ($photos as $p) {
            if (!empty($p->galleryId)) {
                $galleryPhotos[$p->galleryId][] = $p;
            }
        }
        return $galleryPhotos;
    }

    /**
     * Delete photos or gallerys data from json file
     * @param $fileName
     * @param $keyType
     * @param $id
     * @return bool|void
     */
    public static function deleteJsonData($fileName, $keyType, $id)
    {
        if (!file_exists($fileName)) {
            return false;
        }
        $jsonString = file_get_contents($fileName);
        $results = Helper::convertJsonStrToArray($jsonString);
        //Delete the json file if it is empty
        if (empty($results) || empty($results[0])) {echo '1111';
            unlink($fileName);
            return;
        }

        $removeKey = ($keyType == 'galleryId') ? Helper::searchByKey($id, $results) : Helper::searchById($id, $results);
        unset($results[$removeKey]);

        $jsonData = empty($results) ? '' : json_encode($results);
        file_put_contents($fileName, $jsonData);

    }
}

?>