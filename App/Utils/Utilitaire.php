<?php
namespace App\Utils;
class Utilitaire{
    public static function cleanInput(?string $valeur):?string{
        return htmlspecialchars(strip_tags(trim($valeur)));
    }
    public static function getFileExtension($file){
        return substr(strrchr($file,'.'),true);
    }
    public static function checkPhoto($_FILES){
        $ext = Utilitaire::getFileExtension($_FILES['photo_personnage']['tmp_name']);
        $exts = ['png','PNG','jpg','JPG','jpeg','JPEG','bmp','BMP']
        $size = $_FILES['photo_personnage']['size'];
        $maxsize = 300000;
        if(in_array($ext,$exts,true) AND $size < $maxsize){
            $uniqueName = uniqid('',true);
            $_FILES['photo_personnage']['name'] = $uniqueName.".".$ext;
            return true
        }
        else{
            $error = 'format incorrect, vérifiez le format de l\'image et qu\'elle ne dépasse les 300ko ';
        }
    }
}