<?php
namespace  UploadFile;

class UploadFile
{


    public function uploadFile ($name, $dir) {

        $extension = array("jpeg", "jpg", "png", "gif");
        $file_name = $_FILES[$name]["name"];
        $file_tmp = $_FILES[$name]["tmp_name"];
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $newFileName = "";

        if (in_array($ext, $extension)) {
            if (file_exists("../public/image/" . $file_name)) {
                move_uploaded_file($file_tmp = $_FILES[$name]["tmp_name"], "../public/image/". $dir .'/'. $file_name);
                $newFileName = $file_name;
            } else {
                $filename = basename($file_name, $ext);
                $newFileName = $filename . time() . "." . $ext;
                move_uploaded_file($file_tmp = $_FILES[$name]["tmp_name"], "../public/image/" .$dir.'/'. $newFileName);
            }
        } else {
            $newFileName = null;
        }
        return $newFileName;
    }
}