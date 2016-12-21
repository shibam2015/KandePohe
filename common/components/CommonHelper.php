<?php
/**
 *
 */
namespace common\components;

use common\models\otherlibraries\Compressimage;
use common\models\otherlibraries\Getextension;
use common\models\otherlibraries\ImageResize;
use common\models\User;
use Yii;
class CommonHelper {

    /*function __construct(argument) {

    }*/

    public static function siteName()
    {
        return 'Kande Pohe';
    }

    public static function  generateUniqueToken($number)
    {
        $arr = array('a', 'b', 'c', 'd', 'e', 'f',
            'g', 'h', 'i', 'j', 'k', 'l',
            'm', 'n', 'o', 'p', 'r', 's',
            't', 'u', 'v', 'x', 'y', 'z',
            'A', 'B', 'C', 'D', 'E', 'F',
            'G', 'H', 'I', 'J', 'K', 'L',
            'M', 'N', 'O', 'P', 'R', 'S',
            'T', 'U', 'V', 'X', 'Y', 'Z',
            '1', '2', '3', '4', '5', '6',
            '7', '8', '9', '0');
        $token = "";
        for ($i = 0; $i < $number; $i++) {
            $index = rand(0, count($arr) - 1);
            $token .= $arr[$index];
        }
        return $token;
    }

    public static function  pr($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

    public static function getCurrentDate()
    {
        date_default_timezone_set('Asia/Kolkata');
        return date('Y-m-d');
    }

    public static function ageCalculator($dob)
    {
        //calculate years of age (input string: YYYY-MM-DD)
        list($year, $month, $day) = explode("-", $dob);

        $year_diff = date("Y") - $year;
        $month_diff = date("m") - $month;
        $day_diff = date("d") - $day;

        if ($day_diff < 0 || $month_diff < 0)
            $year_diff;

        return $year_diff;
    }

    public static function photoUpload($iUserId, $FILES, $PATH, $URL, $SIZE_ARRAY, $OLD_PHOTO = '')
    {
        #pr($FILES);exit;
        global $Obj_User1, $tconfig, $inc_class_path, $txt;
        #$USER_PHOTO_FOLDER = self::getUserUploadFolder(1);
        #$USER_PHOTO_FOLDER = $USER_PHOTO_FOLDER."/".$iUserId;
        $USER_PHOTO_FOLDER = $PATH;
        if (!is_dir($USER_PHOTO_FOLDER)) {
            mkdir($USER_PHOTO_FOLDER, 0777);
        }
        $DEL_IMG = $SIZE_ARRAY;//array('',100,200,50);
        #pr($DEL_IMG);exit;
        $path = $PATH;//$tconfig["tsite_upload_images_member_path"].$iUserId."/";exit;
        $URL = $URL;//$tconfig["tsite_upload_images_member_url"].$iUserId."/";
        $PHOTO = '';

        $actual_image_name = "";
        $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
        #include_once($inc_class_path ."includes_photo/getExtension.php");
        $Getextension = new Getextension();
        #include_once 'includes/getExtension.php';
        $imagename = $FILES['name'];
        $size = $FILES['size'];
        #echo "================ ".$size;exit;
        if (strlen($imagename)) {
            $ext = strtolower($Getextension->getExtension($imagename));
            if (in_array($ext, $valid_formats)) {
                /*if($size<(1024*1024))
                {*/
                $actual_image_name = rand(1, 2000) . time() . substr(str_replace(" ", "_", $txt), 5) . "." . $ext;
                $uploadedfile = $FILES['tmp_name'];
                #include_once($inc_class_path ."includes_photo/compressImage.php");
                $compressImage = new Compressimage();
                #include 'includes/compressImage.php';


                $widthArray = $SIZE_ARRAY;// array(200,100,50);
                foreach ($widthArray as $newwidth) {
                    $filename = $compressImage->compressImage($ext, $uploadedfile, $path, $actual_image_name, $newwidth);
                    #unlink($path.$newwidth.'_1469352590');
                    #echo "<img src='".$filename."' class='img'> <br/>";
                    #  echo "<b>Width:</b> ".$newwidth."px  <br/><b>File Name:</br> ".$filename."<br/><br/>";

                }
                #echo " <br> UP FILE => ".$uploadedfile;
                #echo " <br> PATh NAME=> ".$path.$actual_image_name;
                #var_dump(move_uploaded_file($uploadedfile, $path.$actual_image_name));
                if (move_uploaded_file($uploadedfile, $path . $actual_image_name)) {
                    $PHOTO = $actual_image_name;
                    /*$Obj_User1->select($iUserId);
                    $OLD_PHOTO =  $Obj_User1->getVPhoto();
                    $Obj_User1->setVPhoto(addslashes($actual_image_name));*/
                    $UPDATE_FLAG = 1;//$Obj_User1->uploadPhoto($iUserId);
                    if ($UPDATE_FLAG) {
                        if ($OLD_PHOTO != '') {
                            foreach ($DEL_IMG as $k => $V) {
                                if ($k == 0)
                                    $vImage_hid = $OLD_PHOTO;
                                else
                                    $vImage_hid = $V . '_' . $OLD_PHOTO;
                                unlink($path . $vImage_hid);
                            }
                        }
                        $STATUS = 1;
                        $NOTIFICATION_TYPE = 'Success';
                        $NOTIFICATION_MSG = 'Upload Successfully';
                        #$PHOTO = $URL."100_".$actual_image_name;
                    } else {
                        $STATUS = 0;
                        $NOTIFICATION_TYPE = 'Failed';
                        $NOTIFICATION_MSG = 'Something went wrong. Please try again !';
                    }
                } else {
                    $STATUS = 0;
                    $NOTIFICATION_TYPE = 'Failed';
                    $NOTIFICATION_MSG = 'Fail upload folder with read access.';
                }

                //}
                /*else{
                    $STATUS = 0;
                    $NOTIFICATION_TYPE = 'Failed';
                    echo $NOTIFICATION_MSG = 'Image file size max 1 MB.';//exit;
                }*/

            } else {
                $STATUS = 0;
                $NOTIFICATION_TYPE = 'Failed';
                $NOTIFICATION_MSG = 'Invalid file format..';
            }

        }

        $RES_ARRAY = array("STATUS" => $STATUS, "NOTIFICATION_TYPE" => $NOTIFICATION_TYPE, "NOTIFICATION_MSG" => $NOTIFICATION_MSG, "PHOTO" => $PHOTO);
        #print_r($RES_ARRAY);
        return $RES_ARRAY;

    }

    public static function getPhotos($TYPE = 'USER', $ID, $PHOTO, $SIZE = '', $DefaultStatus = '', $Profile = 'No') // GET USER PHOTO (Profile)
    {
        if ($TYPE == 'USER') {
            $U_PATH = $ID . "/";
            $PHOTO_WITH_SIZE = $PHOTO;
            if ($Profile == 'No') {
                $MAIN_URL = CommonHelper::getUserUploadFolder(2);
                $PATH = CommonHelper::getUserUploadFolder(1) . $U_PATH;
                $URL = $MAIN_URL . $U_PATH;
            } else {
                //$MAIN_URL = CommonHelper::getUserUploadFolder(2);
                $MAIN_URL = CommonHelper::getUserUploadFolder(4, $ID);
                $PATH = CommonHelper::getUserUploadFolder(3, $ID);
                $URL = $MAIN_URL;
            }
            $DefaultPhotoURL = CommonHelper::getUserUploadFolder(2);
            if ($DefaultStatus == '')
                $PHOTO_USER = is_file($PATH . $PHOTO_WITH_SIZE) ? $URL . $PHOTO_WITH_SIZE : $DefaultPhotoURL . 'no-user-img.jpg';
            else
                $PHOTO_USER = is_file($PATH . $PHOTO_WITH_SIZE) ? $URL . $PHOTO_WITH_SIZE : $DefaultPhotoURL . $SIZE . '_no-user-img.jpg';
            return $PHOTO_USER;
        }
    }

    public static function getUserUploadFolder($TYPE = 1, $UserId = '')
    {//For path AND URL
        // User : echo CommonHelper::getUserUploadFolder(2);
        if ($TYPE == 1) {
            $USER_UPLOAD = Yii::getAlias('@frontend') . '/web/uploads/users/';
        } else if ($TYPE == 2) {
            $USER_UPLOAD = CommonHelper::getHost() . '/uploads/users/';
        } else if ($TYPE == 3) { //Profile Photo Path
            $USER_UPLOAD = Yii::getAlias('@frontend') . '/web/uploads/users/' . $UserId . '/profile/';
        } else if ($TYPE == 4) { //Profile Photo URL
            $USER_UPLOAD = CommonHelper::getHost() . '/uploads/users/' . $UserId . '/profile/';
        } else {
            $USER_UPLOAD = '/uploads/users/';
        }
        return $USER_UPLOAD;
    }

    public static function getHost()
    {
        $HostName = "http://" . $_SERVER["HTTP_HOST"] . Yii::getAlias('@web');
        return $HostName;
    }

    public static function getUserDefaultPhoto()
    {
        $MAIN_URL = CommonHelper::getHost() . CommonHelper::getUserUploadFolder(3);
        return $MAIN_URL . 'no-user-img.jpg';
    }

    /**
     * For get Logo Name
     */
    public static function getLogo($TYPE = 1)
    {
        $LOGO_DIR = Yii::getAlias('@web') . '/images/';
        if ($TYPE = 1)
            $img = $LOGO_DIR . 'logo.png';

        return $img;
    }

    /**
     *    Date Time Formate Get
     *
     **/
    public static function DateTime($text, $format = '', $time = '')
    {
        if ($text == "" || $text == "0000-00-00 00:00:00" || $text == "0000-00-00")
            return "---";
        switch ($format) {
            //us formate
            case "1":
                return date('M j, Y', strtotime($text));
                break;

            case "2":
                return date('M j, y  [G:i] ', strtotime($text));
                break;

            case "3":
                return date("M j, Y", $text);
                break;

            case "4":
                return date('Y,n,j,G,', $text) . intval(date('i', $text)) . ',' . intval(date('s', $text));
                break;

            case "5":
                return date('l, F j, Y', strtotime($text));
                break;

            case "6":
                return date('g:i:s', $text);
                break;

            case "7":
                return date('F j, Y  h:i A', strtotime($text));
                break;

            case "8":
                return date('Y-m-d', strtotime($text));
                break;
            case "9":
                return date('F j, Y', strtotime($text));
                break;
            case "10":
                return date('d/m/Y', strtotime($text));
                break;
            case "11":
                return date('m/d/y', strtotime($text));
                break;
            case "12":
                return date('H:i', strtotime($text));
                break;
            case "13":
                return date('F j, Y (H:i:s)', strtotime($text));
                break;
            case "14":
                return date('j-M-Y', strtotime($text));
                break;
            case "15":
                return date('D', strtotime($text));
                break;
            case "16":
                return date('d', strtotime($text));
                break;
            case "17":
                return date('M Y', strtotime($text));
                break;
            case "18":
                return date('h:i A', strtotime($text));
                break;
            case "19":
                return date('M j, Y', strtotime($text));
                break;
            case "20":
                return date('l,F d', strtotime($text));
                break;
            case "21":
                return date('m/d/y, l', strtotime($text));
                break;
            //Use below(22-23-24) date time format in whole site
            //For Time - 01:00 AM
            case "22":
                return date('h:i A', strtotime($text));
                break;
            //For date 10 Mar 2016
            case "23":
                return date('j M Y', strtotime($text));
                break;
            //For Date and Time  28 Mar 2016 01:00 AM
            case "24":
                return date('j M Y', strtotime($text)) . ' ' . date('h:i A', strtotime($time));
                break;
            //For DateTime type
            case "25":
                return date('j M Y  h:i A', strtotime($text));
                break;
            case "26":
                return date("jS M, Y", strtotime($text));
                break;
            case "27":
                return date("jS M, Y h:i:s a", strtotime($text));
                break;
            case "28":
                return date("jS M, Y h:i a", strtotime($text));
                break;
            default :
                return date('M j, Y', strtotime($text));
                break;
        }
    }

    public static function getCoverPhotos($TYPE = 'USER', $ID, $PHOTO, $SIZE = '') // GET USER PHOTO (Profile)
    {
        if ($TYPE == 'USER') {
            $U_PATH = $ID . "/cover/";

            if ($SIZE != '') {
                $PHOTO_WITH_SIZE = $SIZE . "_" . $PHOTO;
            } else {
                $PHOTO_WITH_SIZE = $PHOTO;
            }
            $MAIN_URL = CommonHelper::getUserUploadFolder(2);
            $PATH = CommonHelper::getUserUploadFolder(1) . $U_PATH;
            $URL = $MAIN_URL . $U_PATH;
            #$PHOTO_USER = is_file($PATH . $PHOTO_WITH_SIZE) ? $URL . $PHOTO_WITH_SIZE : $MAIN_URL . 'no-user-img.jpg';
            $PHOTO_USER = is_file($PATH . $PHOTO_WITH_SIZE) ? $URL . $PHOTO_WITH_SIZE : $MAIN_URL . 'profile-bg.jpg';
            #$PHOTO_USER = is_file($PATH . $PHOTO_WITH_SIZE) ? $URL . $PHOTO_WITH_SIZE : 'http://placehold.it/350x150';
            return $PHOTO_USER;
        }
    }

    public static function coverPhotoUpload($iUserId, $FILES, $PATH, $URL, $SIZE_ARRAY = '', $OLD_PHOTO = '')
    {
        global $Obj_User1, $tconfig, $inc_class_path, $txt;
        $USER_PHOTO_FOLDER = $PATH;
        if (!is_dir($USER_PHOTO_FOLDER)) {
            mkdir($USER_PHOTO_FOLDER, 0777);

        }
        $path = $PATH;//$tconfig["tsite_upload_images_member_path"].$iUserId."/";exit;
        $URL = $URL;//$tconfig["tsite_upload_images_member_url"].$iUserId."/";
        $PHOTO = '';

        $actual_image_name = "";
        $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
        $Getextension = new Getextension();
        $imagename = $FILES['name'];
        $size = $FILES['size'];
        if (strlen($imagename)) {
            $ext = strtolower($Getextension->getExtension($imagename));
            if (in_array($ext, $valid_formats)) {
                /*if($size<(1024*1024))
                {*/
                $actual_image_name = rand(1, 2000) . time() . substr(str_replace(" ", "_", $txt), 5) . "." . $ext;
                $uploadedfile = $FILES['tmp_name'];

                if (move_uploaded_file($uploadedfile, $path . $actual_image_name)) {
                    $PHOTO = $actual_image_name;
                    $UPDATE_FLAG = 1;
                    if ($UPDATE_FLAG && $OLD_PHOTO != '') {
                        CommonHelper::photoDeleteFromFolder($PATH, array(), $OLD_PHOTO);
                        $STATUS = 1;
                        $NOTIFICATION_TYPE = 'Success';
                        $NOTIFICATION_MSG = 'Upload Successfully';
                        #$PHOTO = $URL."100_".$actual_image_name;
                    } else {
                        $STATUS = 0;
                        $NOTIFICATION_TYPE = 'Failed';
                        $NOTIFICATION_MSG = 'Something went wrong. Please try again !';
                    }
                } else {
                    $STATUS = 0;
                    $NOTIFICATION_TYPE = 'Failed';
                    $NOTIFICATION_MSG = 'Fail upload folder with read access.';
                }

            } else {
                $STATUS = 0;
                $NOTIFICATION_TYPE = 'Failed';
                $NOTIFICATION_MSG = 'Invalid file format..';
            }

        }

        $RES_ARRAY = array("STATUS" => $STATUS, "NOTIFICATION_TYPE" => $NOTIFICATION_TYPE, "NOTIFICATION_MSG" => $NOTIFICATION_MSG, "PHOTO" => $PHOTO);
        #print_r($RES_ARRAY);exit;
        return $RES_ARRAY;

    }

    public static function photoDeleteFromFolder($PATH, $SIZE_ARRAY, $OLD_PHOTO)
    {
        $DEL_IMG = $SIZE_ARRAY;
        $path = $PATH;
        if ($OLD_PHOTO != '') {
            if (count($SIZE_ARRAY) != 0) {
                foreach ($DEL_IMG as $k => $V) {
                    if ($k == 0)
                        $vImage_hid = $OLD_PHOTO;
                    else
                        $vImage_hid = $V . '_' . $OLD_PHOTO;
                    unlink($path . $vImage_hid);
                }
            } else {
                $vImage_hid = $OLD_PHOTO;
                unlink($path . $vImage_hid);
            }

        }
        return true;
    }

    public static function getSiteUrl($TYPE = 'FRONTEND', $Mail = '')
    {

        if ($TYPE == 'FRONTEND') {
            $site_url = "http://" . $_SERVER["HTTP_HOST"] . Yii::getAlias('@web') . "/frontend/web/";
        } else {
            $site_url = "http://" . $_SERVER["HTTP_HOST"] . Yii::getAlias('@web') . "/backend/web/";
        }
        if ($Mail != '') {
            $site_url = "http://" . $_SERVER["HTTP_HOST"] . Yii::getAlias('@web') . "/";
        }
        return $site_url;
    }

    public static function getMessage($TYPE = '')
    {

    }

    public static function getSiteUrlLogo()
    {
        //$site_url_logo = "http://" . $_SERVER["HTTP_HOST"] . Yii::getAlias('@web') . "/frontend/web/images/logo.png";
        $site_url_logo = "http://" . $_SERVER["HTTP_HOST"] . Yii::getAlias('@web') . "/images/logo.png";
        return $site_url_logo;
    }

    public static function generateUniqueRandomNumber($length = 9)
    {
        $PREFIX = CommonHelper::generatePrefix();
        $RANDOM_USER_NUMBER = $PREFIX . CommonHelper::generateNumericUniqueToken($length);
        if (!User::findOne(['Registration_Number' => $RANDOM_USER_NUMBER]))
            return $RANDOM_USER_NUMBER;
        else
            return CommonHelper::generateUniqueRandomNumber($length);
    }

    public static function generatePrefix()
    {
        return 'KP';
    }

    public static function generateNumericUniqueToken($number)
    {
        $arr = array('1', '2', '3', '4', '5', '6', '7', '8', '9');
        $token = "";
        for ($i = 0; $i < $number; $i++) {
            $index = rand(0, count($arr) - 1);
            $token .= $arr[$index];
        }
        return $token;
    }

    public static function getPhotosBackend($TYPE = 'USER', $ID, $PHOTO, $SIZE = '', $DefaultStatus = '', $Profile = 'No', $dir = 0) // GET USER PHOTO (Profile)
    {
        if ($TYPE == 'USER') {
            $U_PATH = $ID . "/";
            $PHOTO_WITH_SIZE = $PHOTO;
            if ($Profile == 'No') {
                $MAIN_URL = CommonHelper::getUserUploadFolderBackend(2, $ID, $dir);
                $PATH = CommonHelper::getUserUploadFolderBackend(1) . $U_PATH;
                $URL = $MAIN_URL . $U_PATH;
            } else {
                $MAIN_URL = CommonHelper::getUserUploadFolderBackend(4, $ID, $dir);
                $PATH = CommonHelper::getUserUploadFolderBackend(3, $ID, $dir);
                $URL = $MAIN_URL;
            }
            $DefaultPhotoURL = CommonHelper::getUserUploadFolderBackend(2);

            if ($DefaultStatus == '')
                $PHOTO_USER = is_file($PATH . $PHOTO_WITH_SIZE) ? $URL . $PHOTO_WITH_SIZE : $DefaultPhotoURL . 'no-user-img.jpg';
            else
                $PHOTO_USER = is_file($PATH . $PHOTO_WITH_SIZE) ? $URL . $PHOTO_WITH_SIZE : $DefaultPhotoURL . $SIZE . '_no-user-img.jpg';
            return $PHOTO_USER;
        }
    }

    public static function getUserUploadFolderBackend($TYPE = 1, $UserId = '', $dir = 0)
    {
        if ($TYPE == 1) {
            $USER_UPLOAD = Yii::getAlias('@frontend') . '/web/uploads/users/';
        } else if ($TYPE == 2) {
            if ($dir == 0)
                $USER_UPLOAD = '../../../frontend/web/uploads/users/';
            else
                $USER_UPLOAD = '../../../../frontend/web/uploads/users/';
        } else if ($TYPE == 3) { //Profile Photo Path
            $USER_UPLOAD = Yii::getAlias('@frontend') . '/web/uploads/users/' . $UserId . '/profile/';
        } else if ($TYPE == 4) { //Profile Photo URL
            #$USER_UPLOAD =  '../../../frontend/web/uploads/users/' . $UserId . '/profile/';
            if ($dir == 0)
                $USER_UPLOAD = '../../../frontend/web/uploads/users/' . $UserId . '/profile/';
            else
                $USER_UPLOAD = '../../../../frontend/web/uploads/users/' . $UserId . '/profile/';
        } else {
            if ($dir == 0)
                $USER_UPLOAD = '../../../frontend/web/uploads/users/';
            else
                $USER_UPLOAD = '../../../../frontend/web/uploads/users/';
        }
        return $USER_UPLOAD;
    }

    public static function unsetStep($OriginalString, $UnsetString)
    { # For Phone Verification : VS
        $OriginalString = str_replace("," . $UnsetString, '', $OriginalString);
        $OriginalString = str_replace($UnsetString . ",", '', $OriginalString);
        return $OriginalString;
    }

    public static function getUserUrl($RNo = '', $Type)
    {
        $UserUrl = 'user/profile?uk=';
        switch ($Type) {
            case "1":
                break;
            default :
                return Yii::$app->homeUrl . $UserUrl . $RNo;

        }
    }

    public static function getMailBoxUrl($RNo = '', $Type = '')
    {
        $MailBoxUrl = 'mailbox/';
        switch ($Type) {
            case "1"://more-conversation
                return Yii::$app->homeUrl . $MailBoxUrl . 'more-conversation?uk=' . $RNo;
                break;
            case "2":
                //SentBox
                return Yii::$app->homeUrl . $MailBoxUrl . 'sentbox';
                break;
            default :
                return Yii::$app->homeUrl . $MailBoxUrl;

        }
    }

    public static function getCommaSeperatedValue($MainArray, $key)
    {
        $Names = '';
        if (count($MainArray)) {
            foreach ($MainArray as $K => $V) {
                $Names .= $V[$key] . " , ";
            }
        }
        return trim($Names, " , ");
    }

    public static function removeComma($MainArray)
    {
        if (strlen($MainArray) > 0) {
            if (strlen($MainArray) == 1 && $MainArray == 0) {
                return 0;
            } else {
                return implode(",", array_filter(explode(",", $MainArray)));
            }
        }
        else
            return 0;
    }

    public static function setInputVal($val, $type = "text")
    {

        $RetVal = "";
        switch ($type) {
            case 'text':
                $RetVal = $val == "" ? '-' : $val;
                break;

            case 'age':
                $RetVal = $val == "" ? '-' : $val . " Years";
                break;
        }
        return $RetVal;
    }

    public static function setCommaInValue($str)
    {
        return ($str != '-') ? ', ' . $str : '';
    }

    public static function photoUploads($iUserId, $FILES, $PATH, $URL, $SIZE_ARRAY, $OLD_PHOTO = '')
    {
        #CommonHelper::pr($FILES);exit;

        $config["generate_image_file"] = true;
        $config["generate_thumbnails"] = true;
        $config["image_max_size"] = 1000; //Maximum image size (height and width)
        #$config["thumbnail_size"]  			= 150; //Thumbnails will be cropped to 200x200 pixels
        $config["thumbnail_prefix"] = Yii::$app->params['thumbnailPrefix']; //Normal thumb Prefix
        $config["destination_folder"] = $PATH;//'uploads/'; //upload directory ends with / (slash)
        $config["thumbnail_destination_folder"] = $PATH;//'uploads/'; //upload directory ends with / (slash)
        $config["upload_url"] = $URL;//"http://localhost/Demo/photo/ajax-image-upload-master/uploads/";
        $config["quality"] = 100; //jpeg quality
        $config["random_file_name"] = true; //randomize each file name
        $config["file_data"] = $FILES;
        $config["thumbnail_size"] = CommonHelper::getUserResizeRatio();
        $ImageResize = new ImageResize($config);
        $UploadFolderPath = $PATH;
        if (!is_dir($UploadFolderPath)) {
            mkdir($UploadFolderPath, 0777);
        }
        try {
            $ImageResponse = $ImageResize->resize(); //initiate image resize
            $STATUS = 1;
            /*echo '<h3>Thumbnails</h3>';
            //output thumbnails
            foreach($ImageResponse["thumbs"] as $response){
                echo '<img src="'.$config["upload_url"].$response.'" class="thumbnails" title="'.$response.'" />';
            }
            echo '<h3>Images</h3>';
            //output images
            foreach($ImageResponse["images"] as $response){
                echo '<img src="'.$config["upload_url"].$response.'" class="images" title="'.$response.'" />';
            }*/
        } catch (Exception $e) {
            $STATUS = 1;
            $MESSAGE = $e->getMessage();
        }
        return array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, "PhotoArray" => $ImageResponse);

    }

    public static function getUserResizeRatio()
    {//For User photo resize
        #$USER_SIZE_ARRAY = array('', 30, 75, 140, 200, 350, 500, 900);
        $USER_SIZE_ARRAY = array(30, 63, 75, 110, 120, 155, 180, 200, 260);
        return $USER_SIZE_ARRAY;
    }

    public static function replaceNotificationMessage($Message, $ParamArray)
    {
        $MesssageArray = array('#TSF#', '#TFA#', '#LIMIT#');
        foreach ($MesssageArray as $Key => $Value) {
            $ArrayKey = str_replace('#', '', $Value);
            if (array_key_exists($ArrayKey, $ParamArray)) {
                $NotificationMsg = str_replace($Value, $ParamArray[$ArrayKey], $Message);
            }
        }
        return $NotificationMsg;
    }

    /****
     * For Get Photo Height
     ***/
    public static function getPhotoHeight($image)
    {
        $sizes = getimagesize($image);
        $height = $sizes[1];
        return $height;
    }

    /****
     * For Get Photo Width
     ***/
    public static function getPhotoWidth($image)
    {
        $sizes = getimagesize($image);
        $width = $sizes[0];
        return $width;
    }

    /****
     * For Resize Profile Photo
     ***/
    public static function resizeImage($image, $width, $height, $scale)
    {
        $newImageWidth = ceil($width * $scale);
        $newImageHeight = ceil($height * $scale);
        $newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);
        $source = imagecreatefromjpeg($image);
        imagecopyresampled($newImage, $source, 0, 0, 0, 0, $newImageWidth, $newImageHeight, $width, $height);
        imagejpeg($newImage, $image, 90);
        chmod($image, 0777);
        return $image;
    }

    public static function ProfilePhotoDeleteFromFolder($PATH, $SIZE_ARRAY, $OLD_PHOTO)
    {
        $DEL_IMG = $SIZE_ARRAY;
        $path = $PATH;
        if ($OLD_PHOTO != '') {
            if (count($SIZE_ARRAY) != 0) {
                foreach ($DEL_IMG as $k => $V) {
                    $vImage_hid = $V . $OLD_PHOTO;
                    unlink($path . $vImage_hid);
                }
            } else {
                $vImage_hid = $OLD_PHOTO;
                unlink($path . $vImage_hid);
            }
        }
        return true;
    }

    public static function commonCroppingUpload($Data, $NewFileName, $Size = '')
    {
        #CommonHelper::pr($Data);exit;
        $ImageName = $Data['ImageName'];
        $ImageUrl = $Data['imgUrl'];
// original sizes
        $imgInitW = $Data['imgInitW'];
        $imgInitH = $Data['imgInitH'];
// resized sizes
        $imgW = $Data['imgW'];
        $imgH = $Data['imgH'];
// offsets
        $imgY1 = $Data['imgY1'];
        $imgX1 = $Data['imgX1'];
// crop box
        $cropW = $Data['cropW'];
        $cropH = $Data['cropH'];
// rotation angle
        $angle = $Data['rotation'];

        $what = getimagesize($ImageUrl);
        $type = '';
        switch (strtolower($what['mime'])) {
            case 'image/png':
                $img_r = imagecreatefrompng($ImageUrl);
                $source_image = imagecreatefrompng($ImageUrl);
                $type = '.png';
                break;
            case 'image/jpeg':
                $img_r = imagecreatefromjpeg($ImageUrl);
                $source_image = imagecreatefromjpeg($ImageUrl);
                error_log("jpg");
                $type = '.jpeg';
                break;
            case 'image/gif':
                $img_r = imagecreatefromgif($ImageUrl);
                $source_image = imagecreatefromgif($ImageUrl);
                $type = '.gif';
                break;
            default:
                die('image type not supported');
        }

        if (!is_writable(dirname($NewFileName))) {
            $response = Array(
                "status" => 'error',
                "message" => 'Can`t write cropped File'
            );
        } else {
            $jpeg_quality = 100;
            // resize the original image to size of editor
            $resizedImage = imagecreatetruecolor($imgW, $imgH);
            imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, $imgH, $imgInitW, $imgInitH);
            // rotate the rezized image
            $rotated_image = imagerotate($resizedImage, -$angle, 0);
            // find new width & height of rotated image
            $rotated_width = imagesx($rotated_image);
            $rotated_height = imagesy($rotated_image);
            // diff between rotated & original sizes
            $dx = $rotated_width - $imgW;
            $dy = $rotated_height - $imgH;
            // crop rotated image to fit into original rezized rectangle
            $cropped_rotated_image = imagecreatetruecolor($imgW, $imgH);
            imagecolortransparent($cropped_rotated_image, imagecolorallocate($cropped_rotated_image, 0, 0, 0));
            imagecopyresampled($cropped_rotated_image, $rotated_image, 0, 0, $dx / 2, $dy / 2, $imgW, $imgH, $imgW, $imgH);
            // crop image into selected area
            //$final_image = imagecreatetruecolor($cropW, $cropH); //Cropping Section Heigth and Width
            $final_image = imagecreatetruecolor($cropW, $cropH);
            imagecolortransparent($final_image, imagecolorallocate($final_image, 0, 0, 0));
            imagecopyresampled($final_image, $cropped_rotated_image, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW, $cropH);
            // finally output png image
            imagepng($final_image, $NewFileName . $type, $png_quality);
            imagejpeg($final_image, $NewFileName . $type, $jpeg_quality);

            $response = Array(
                "status" => 'success',
                "url" => $NewFileName . $type,
                "picname" => $ImageName . $type,
            );
        }
        #print json_encode($response);
        return $response;
    }

    public static function getTimeDifference($Time,$Type=0){
        $Difference = $RemainingTime = 0;
        $TimePinExpired = Yii::$app->params['timePinValidate'];
            $CurrentTime = CommonHelper::getDateTimeToString(CommonHelper::getTime());
            $TimeDifference = round(abs($CurrentTime - $Time) / 60,0);
            $TempDiff[0]=$TimeDifference;
            if($TimeDifference>0){
                 $TempDiff = explode(".",$TimeDifference);
             }

            $Seconds = abs($CurrentTime - $Time) % 60;
            //if($TimeDifference>=0 && $TimeDifference<=$TimePinExpired){
            if($TempDiff[0]>=0 && $TempDiff[0]<=$TimePinExpired){
                $Minutes = $TimePinExpired - $TempDiff[0];
                if($TempDiff[0]==$TimePinExpired || $TimeDifference == 0){
                    $TimeDifference = $Minutes = $TimePinExpired-1;
                }
                $Seconds = 60 - $Seconds;
                $RemainingTime = $Minutes.":".$Seconds;
                #echo "<br> IN If";echo "<br> MIn =>".$Minutes;
                #echo "<br> SEC =>".$Seconds;echo "<br> REM T  =>".$RemainingTime;
            }
        return array($TimeDifference,$RemainingTime);
    }

    public static function getDateTimeToString($DateTime)
    {
        return strtotime($DateTime);
    }

    public static function getTime()
    {
        date_default_timezone_set('Asia/Kolkata');
        return date('Y-m-d H:i:s');
    }

    public function getReligion()
    {
        $religion = \common\models\Religion::find()->all();
        return $religion;
    }

    public function getAnnualIncome()
    {
        return \common\models\AnnualIncome::find()->all();
    }

    public function getWorkingWith()
    {
        return \common\models\WorkingWith::find()->all();
    }

    public function getEducationField()
    {
        return \common\models\EducationField::find()->all();
    }

    public function getEducationLevel()
    {
        return \common\models\EducationLevel::find()->all();
    }

    public function getSkinTone()
    {
        $skintone = \common\models\SkinTone::find()->all();
        return $skintone;
    }

    public function getBodyType()
    {
        $bodytype = \common\models\BodyType::find()->all();
        return $bodytype;
    }

    public function getFamilyAffulenceLevel()
    {
        $bodytype = \common\models\FamilyAffluenceLevel::find()->all();
        return $bodytype;
    }

    public function getFamilyPropertyDetail()
    {
        $bodytype = \common\models\PropertyDetails::find()->all();
        return $bodytype;
    }

    public function getWorkingAS()
    {
        return \common\models\WorkingAS::find()->all();
    }

    public function getCommunity()
    {
        return \common\models\MasterCommunity::find()->all();
    }

    public function getSubCommunity()
    {
        return \common\models\MasterCommunitySub::find()->all();
    }

    public function getMaritalStatus()
    {
        return \common\models\MasterMaritalStatus::find()->all();
    }

    public function getGotra()
    {
        return \common\models\MasterGotra::find()->all();
    }

    public function getDistrict()
    {
        return \common\models\MasterDistrict::find()->all();
    }

    public function getTaluka()
    {
        return \common\models\MasterTaluka::find()->all();
    }

    public function getCountry()
    {
        return \common\models\Countries::find()->all();
    }

    public function getState($id = '')
    {
        if ($id == '')
            return \common\models\States::find()->all();
        else
            return \common\models\States::find()->where(['iCountryId' => $id])->all();
    }

    public function getCity($id = '')
    {
        if ($id == '')
            return \common\models\Cities::find()->all();
        else
            return \common\models\Cities::find()->where(['iStateId' => $id])->all();

    }

    public function getHeight()
    {
        return \common\models\MasterHeight::find()->all();
    }

    public function getDiet()
    {
        return \common\models\MasterDiet::find()->all();
    }

    public function getFmstatus()
    {
        return \common\models\MasterFmStatus::find()->all();
    }

    public function getMotherTongue()
    {
        return \common\models\MotherTongue::find()->all();
    }

    public function getRaashi() {
        return \common\models\Raashi::find()->all();
    }

    public function getNaksatra() {
        return \common\models\Nakshtra::find()->all();
    }

    public function getGan() {
        return \common\models\Gan::find()->all();
    }

    public function getNadi() {
        return \common\models\Nadi::find()->all();
    }

    public function getCharan() {
        return \common\models\Charan::find()->all();
    }

    public function getInterests()
    {
        return \common\models\Interests::find()->all();
    }

    public function getFavouriteReads()
    {
        return \common\models\FavouriteReads::find()->all();
    }

    public function getFavouriteMusic()
    {
        return \common\models\FavouriteMusic::find()->all();
    }

    public function getFavouriteCousines()
    {
        return \common\models\FavouriteCousines::find()->all();
    }

    public function getSportsFitnActivities()
    {
        return \common\models\SportsFitnActivities::find()->all();
    }

    public function getPreferredDressStyle()
    {
        return \common\models\PreferredDressStyle::find()->all();
    }

    public function getPreferredMovies()
    {
        return \common\models\PreferredMovies::find()->all();
    }

    public function getMasterGotra()
    {
        return \common\models\MasterGotra::find()->all();
    }

    function encryptor($action, $string)
    {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        //pls set your unique hashing key
        $secret_key = 'vCoderTeam';
        $secret_iv = 'vCoderTeam123';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        //do the encyption given text/string/number
        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            //decrypt the given text/string/number
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

    function truncate($str, $len)
    {
        $tail = max(0, $len - 10);
        $trunk = substr($str, 0, $tail);
        $trunk .= strrev(preg_replace('~^..+?[\s,:]\b|^...~', '...', strrev(substr($str, $tail, $len - $tail))));
        return $trunk;
    }

    function getFrontUpload($img = '')
    {
        #$target_dir = Yii::getAlias('@frontend') .'/web/uploads/';
        $target_dir = Yii::getAlias('@web') . '/uploads/users/';
        $target_dir_default = Yii::getAlias('@web') . '/images/';
        if ($img != '')
            $img = $target_dir . $img;
        else
            $img = $target_dir_default . 'placeholder.jpg';

        #echo $img;exit;
        return $img;
    }

    function getAge($then) {
        $then_ts = strtotime($then);
        $then_year = date('Y', $then_ts);
        $age = date('Y') - $then_year;
        if(strtotime('+' . $age . ' years', $then_ts) > time()) $age--;
        return $age;
    }

    function new_thumb_name($filename)
    {
        $string = trim($filename);
        $string = strtolower($string);
        $string = trim(ereg_replace("[^ A-Za-z0-9_]", " ", $string));
        $string = ereg_replace("[ tnr]+", "_", $string);
        $string = str_replace(" ", '_', $string);
        $string = ereg_replace("[ _]+", "_", $string);

        return $string;
    }
}
?>

