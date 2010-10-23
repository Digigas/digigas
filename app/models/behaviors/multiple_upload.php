<?php
/**
 *  Improved Multiple Upload Behaviour
 *  This behaviour is based on Chris Partridge's upload behaviour (http://bin.cakephp.org/saved/17539)
 *  @author Tane Piper (digitalspaghetti@gmail.com)
 *  @link http://www.digitalspaghetti.me.uk
 *  @filesource http://bakery.cakephp.org/articles/view/improved-upload-behaviour-with-thumbnails-and-name-correction
 *  @version 1.2.1
 *  @modifiedby      $LastChangedBy: dalpo85@gmail.com
 *  @lastmodified    $Date:2008/07/29$
 *  @svn             $Id:$
 *
 *  Version Details
 *  1.2.1
 *  + Rewritten dalpo
 *
 *
 *  1.2
 *  + Rewritten AD7six
 *
 *  1.1
 *  + Improved Image scaling code
 *  + Fixed check to see if file exists and rename file to unique name
 *  + Improved model actsAs to allow more thumbnail sizes
 *
 *  1.0
 *  + Initial release with thumbnail code.
 */

//use
/*
class Company extends AppModel {
 
    var $name = 'Company';
    var $actsAs = array('MultipleUpload' =>
                            array(
                                'photo' => array(
                                    'field' => 'photo',
                                    'dir' => "{IMAGES}company", //markers: '{APP}', '{DS}', '{IMAGES}', '{WWW_ROOT}', '{FILES}'
                                    'deleteMainFile' => true,
									'randomFilenames' => true,
                                    'thumbsizes' => array(                   
                                        'main' => array('width' => 350, 'height' => 350, 'name' => 'main.{$file}.{$ext}', 'autoResize' => false, 'quality' => 75)
											//'autoResize' => true/false/'resize'/'resizeCrop'/'crop'                   
                                    )
                                )
                            )
                        );
    var $validate = array(
        'photo' => array (
            'valid_upload' => array (
                'rule' => array('validateUploadedFile'),
                'message' => 'File non valido',
                'required' => true     
            ),
            'validFile' => array (
                'rule' => array('validateFileExtension', array('gif', 'jpg', 'jpeg', 'png')),
                'message' => 'File non valido, inserire solo file jpg/jpeg, gif o png'
            ),
            'maxFileSize' => array(
                'rule' => array('maxFileSize', 2097152),
                'message' => 'File non valido, inserire file di dimensioni inferiori ai 2 MegaByte'
            )
        )
 
}
*/
class MultipleUploadBehavior extends ModelBehavior {
    var $__defaultSettings = array(
        'defaultSettings' => array(

                'field' => 'photo',
                'allowedMime' => array('image/jpeg', 'image/pjpeg', 'image/gif', 'image/png', 'image/x-png'),
                'allowedExt' => array('jpg','jpeg','gif','png'),
                'overwriteExisting' => false,
                'deleteMainFile' => false,
                'createDirectory' => true,
                'randomFilenames' => true,
                'thumbsizes' => array(
                        'small' => array('width' => 100, 'height' => 100, 'name' => 'small.{$file}.{$ext}', 'autoResize' => true, 'quality' => 75),
                        'medium' => array('width' => 220, 'height' => 220, 'name' => 'medium.{$file}.{$ext}', 'autoResize' => true, 'quality' => 75),
                        'large' => array('width' => 800, 'height' => 600, 'name' => 'large.{$file}.{$ext}', 'autoResize' => true, 'quality' => 75)
                ),
                'dir' => '{APP}uploads{DS}{$class}{DS}{$foreign_id}',
                'nameCleanups' => array(
                //'/&(.)(tilde);/' => "$1y", // �s
                //'/&(.)(uml);/' => "$1e", // umlauts but umlauts are not pronounced the same is all languages.
                //'/?/' => 'ss', // German double s
                //'/&(.)elig;/' => '$1e', // ae and oe symbols
                //'/?/' => 'eth' // Icelandic eth symbol
                //'/?/' => 'thorn' // Icelandic thorn
                        '/&(.)(acute|caron|cedil|circ|elig|grave|horn|ring|slash|th|tilde|uml|zlig);/' => '$1', // strip all
                        'decode' => true, // html decode at this point
                        '/\&/' => ' and ', // Ampersand
                        '/\+/' => ' plus ', // Plus
                        '/([^a-z0-9\.]+)/' => '_', // None alphanumeric
                        '/\\_+/' => '_' // Duplicate sperators
                )
        )
    );
    function setup(&$model, $config=array()) {
        $settings = am ($this->__defaultSettings, $config);
        uses('folder');
        $this->settings[$model->name] = $settings;
    }
    /**
     * Before Save Method..
     *
     * @param object $model
     * @return boolean
     */
    function beforeSave(&$model) {
        $uploadedFiles  = array();
        $error = true;
        foreach ($this->settings[$model->name] as $keyName => $fileValues) {
            if($keyName == 'defaultSettings') continue;
            extract(am($this->settings[$model->name]['defaultSettings'],$fileValues));

            // Check for upload
            if(!isset($model->data[$model->name][$field])) {
                continue;
            }
            if($model->data[$model->name][$field]['error'] == 4) {
                unset($model->data[$model->name][$field]);
                continue;
            }
            // Check it's a file submission
            if (!is_array($model->data[$model->name][$field])) {
                debug($field.' is not an array\nForm must be multipart/form-data');
                $error = false;
                break;
            }
            // Check error
            if($model->data[$model->name][$field]['error'] > 0) {
                debug('Not valid file\nerror in upload data');
                $error = false;
                break;
            }
            // Check mime
            if(count($allowedMime) > 0 && !in_array($model->data[$model->name][$field]['type'], $allowedMime)) {
                debug($field.' > '.$model->data[$model->name][$field]['type'].' is not a valid file\nerror in mime type');
                $error = false;
                break;
            }
            // Check extensions
            $parts = explode('.', low($model->data[$model->name][$field]['name']));
            $extension = array_pop($parts);
            $filename = implode('.', $parts);
            if(count($allowedExt) > 0 && !in_array($extension, $allowedExt)) {
                debug($field.' is not a valid file\nerror with extension '. $extension);
                $error = false;
                break;
            }
            // Get filename
            $filename = $this->_getFilename($model, $fileValues, $filename);
            $model->data[$model->name][$field]['name'] = $filename.'.'.$extension;

            // Get file path
            $dir = $this->_getPath($model, $fileValues, $dir);
            if (!$dir) {
                debug('couldn\'t determine or create directory for the field '.$field);
                $error = false;
                break;
            }
            // Create final save path
            $saveAs = $dir . DS . $model->data[$model->name][$field]['name'];

            // Check if file exists
            if(file_exists($saveAs)) {
                if(!$settings['overwrite_existing'] || !unlink($saveAs)) {
                    $model->data[$model->name][$field]['name'] = uniqid("") . $extension;
                    $saveAs = $dir . DS . $model->data[$model->name][$field]['name'];
                }
            }

            // Attempt to move uploaded file
            if(!move_uploaded_file($model->data[$model->name][$field]['tmp_name'], $saveAs)) {
                debug('could not move file');
                $error = false;
                break;
            }

            $uploadedFiles[$keyName] = array(
                'dir' => $dir,
                'filename' => $model->data[$model->name][$field]['name'],
                'saveas' => $saveAs
            );
        }

        // If there are errors delete all uploaded files
        if(!$error) {
            foreach ($uploadedFiles as $file) {
                unlink($file['saveas']);
            }
            return false;
        }

        //if all files are uploaded then
        foreach ($this->settings[$model->name] as $keyName => $fileValues) {
            if($keyName == 'defaultSettings') continue;
            extract(am($this->settings[$model->name]['defaultSettings'],$fileValues));
            // Check for upload
            if(!isset($model->data[$model->name][$field]) || $model->data[$model->name][$field]['error'] == 4) continue;

            //on Edit or Update delete old files
            if(isset($model->data[$model->name]['id'])) {
                $oldFileName = $model->findById($model->id,array($model->name.'.'.$field));

                foreach ($thumbsizes as $key => $thumbsize) {
                    //unlink($this->_getPath($model,$dir).DS.$this->getThumbname($model, $key, $fileName[$model->name][$field]));
                    if(file_exists($this->_getPath($model,$fileValues,$dir).DS.$this->getThumbname($model, $fileValues, $key, $oldFileName[$model->name][$field]))
                        && !is_dir($this->_getPath($model,$fileValues,$dir).DS.$this->getThumbname($model, $fileValues, $key, $oldFileName[$model->name][$field]))) {
                        unlink($this->_getPath($model,$fileValues,$dir).DS.$this->getThumbname($model, $fileValues, $key, $oldFileName[$model->name][$field]));
                    }
                }
                if(file_exists($this->_getPath($model,$fileValues,$dir).DS.$oldFileName[$model->name][$field])
                    && !is_dir($this->_getPath($model,$fileValues,$dir).DS.$oldFileName[$model->name][$field])) {
                    unlink($this->_getPath($model,$fileValues,$dir).DS.$oldFileName[$model->name][$field]);
                }
            }

            // Create thumbnail of uploaded image
            // This is hard-coded to only support JPEG + PNG + GIF at this time
            if (count($allowedExt) > 0 && in_array($model->data[$model->name][$field]['type'], $allowedMime)) {
                foreach ($thumbsizes as $key => $value) {
                    if(!isset($value['autoResize'])) $value['autoResize'] = true;
                    if(!isset($value['quality'])) $value['quality'] = 75;
                    $thumbName = $this->getThumbname ($model, $fileValues, $key, $uploadedFiles[$keyName]['filename']);
                    $this->createthumb($model, $uploadedFiles[$keyName]['saveas'], $uploadedFiles[$keyName]['dir'] . DS . $thumbName, $value['width'], $value['height'], $value['autoResize'], $value['quality']);
                }
            }

            // Update model data
            $model->data[$model->name]['dir'] = str_replace(ROOT . DS . APP_DIR . DS, '', $dir);
            $model->data[$model->name]['mimetype'] =  $model->data[$model->name][$field]['type'];
            $model->data[$model->name]['filesize'] = $model->data[$model->name][$field]['size'];
            $model->data[$model->name][$field] = $model->data[$model->name][$field]['name'];

            //if deleteMainFile = true then delete it and keep only thumbnails
            if($deleteMainFile && file_exists($uploadedFiles[$keyName]['saveas'])) {
                unlink($uploadedFiles[$keyName]['saveas']);
            }
        }
        //    pr($model->data);
        //    die('beha');
    }

    function beforeDelete(&$model) {
        foreach ($this->settings[$model->name] as $keyName => $fileValues) {
            if($keyName == 'defaultSettings') continue;
            extract(am($this->settings[$model->name]['defaultSettings'],$fileValues));

            $fileName = $model->findById($model->id,array($model->name.'.'.$field));
            foreach ($thumbsizes as $key => $thumbsize) {
                $dFile = $this->_getPath($model,$fileValues,$dir).DS.$this->getThumbname($model, $fileValues, $key, $fileName[$model->name][$field]);
                if(file_exists($dFile) && !is_dir($dFile)) {
                    unlink($dFile);
                }
            }
            $dFile = $this->_getPath($model,$fileValues,$dir).DS.$fileName[$model->name][$field];
            if(file_exists($dFile) && !is_dir($dFile)) {
                unlink($dFile);
            }
        }
    }



    // Function to create thumbnail image

    function createthumb(&$model, $name, $filename, $new_w, $new_h, $autoResize = true, $quality = 75) {

        $system = explode(".", $name);
        if (preg_match("/jpg|jpeg/i", $system[count($system)-1])) {
            $src_img = imagecreatefromjpeg($name);
        }

        if (preg_match("/png/i", $system[count($system)-1])) {
            $src_img = imagecreatefrompng($name);
        }

        if (preg_match("/gif/i", $system[count($system)-1])) {
            $src_img = imagecreatefromgif($name);
        }

        $old_x = imagesx($src_img);

        $old_y = imagesy($src_img);

        $model->data[$model->name]['width'] = $old_x;

        $model->data[$model->name]['height'] = $old_y;


        //    //return false if the thumbnails is greater than image..
        //    if (($old_x < $new_w) || ($old_y < $new_h)) {
        //
        //      return false;
        //
        //    }

        //calculate the new dimensions proportionately


        if($autoResize) {
            /*
            if ($old_x >= $old_y) {
                $thumb_w = $new_w;
                $ratio = $old_y / $old_x;
                $thumb_h = $ratio * $new_w;
            } else if ($old_x < $old_y) {
                $thumb_h = $new_h;
                $ratio = $old_x / $old_y;
                $thumb_w = $ratio * $new_h;
            }
            */
            switch($autoResize) {
                case 'resizeCrop':
                // -- resize to max, then crop to center
                    $ratioX = $new_w / $old_x;
                    $ratioY = $new_h / $old_y;

                    if ($ratioX < $ratioY) {
                        $startX = round(($old_x - ($new_w / $ratioY))/2);
                        $startY = 0;
                        $old_x = round($new_w / $ratioY);
                        $old_y = $old_y;
                    } else {
                        $startX = 0;
                        $startY = round(($old_y - ($new_h / $ratioX))/2);
                        $old_x = $old_x;
                        $old_y = round($new_h / $ratioX);
                    }
                    $thumb_w = $new_w;
                    $thumb_h = $new_h;
                    break;
                case 'crop':
                // -- a straight centered crop
                    $startY = ($old_y - $new_h)/2;
                    $startX = ($old_x - $new_w)/2;
                    $old_y = $new_h;
                    $thumb_h = $new_h;
                    $old_x = $new_w;
                    $thumb_w = $new_w;
                    break;
                case 'resize':
                default:
                // corretta gestione delle proporzioni
                    if ($old_x/$old_y > $new_w/$new_h) {
                        $thumb_w = $new_w;
                        $ratio = $old_x / $old_y; // $new_w/$new_h = $ratio
                        $thumb_h = ceil($new_w / $ratio);
                        //debug($ratio.', '.$thumb_h);
                    } else {
                        $thumb_h = $new_h;
                        $ratio = $old_x / $old_y; // $new_w/$new_h = $ratio
                        $thumb_w = ceil($ratio * $new_h);
                        //debug($ratio.', '.$thumb_w);
                    }
                    $startX = 0;
                    $startY = 0;
                    break;
            }
        } else {
            $thumb_w = $new_w;
            $thumb_h = $new_h;
            $startX = 0;
            $startY = 0;
        }

        if (function_exists("imagecreatetruecolor") && ($dst_img = imagecreatetruecolor($thumb_w, $thumb_h))) {
            imagecopyresampled($dst_img, $src_img, 0, 0, $startX, $startY, $thumb_w, $thumb_h, $old_x, $old_y);
        }
        else {
            $dst_img = imagecreate ($thumb_w, $thumb_h);
            imagecopyresized ($dst_img, $src_img, 0, 0, $startX, $startY, $thumb_w, $thumb_h, $old_x, $old_y);
        }


        if (preg_match("/png/", $system[1])) {
            imagepng($dst_img, $filename, 9 - ($quality/100.0 *9));
        }
        elseif(preg_match("/gif/", $system[1])) {
            imagegif($dst_img, $filename);
        }
        else {
            imagejpeg($dst_img, $filename, $quality);
        }
        imagedestroy($dst_img);
        imagedestroy($src_img);
    }



    function getThumbname ($model, $fileValues, $thumbsize, $filename, $extension = null) {

        if ($extension == null ) {
            $parts = explode('.', low($filename));
            $extension = array_pop($parts);
            $filename = implode('.', $parts);
        }

        $mergedSettings = am($this->settings[$model->name]['defaultSettings']['thumbsizes'],$fileValues['thumbsizes']);
        extract($mergedSettings[$thumbsize]);

        if (strpos($name, '{') === false) {
            return $name.$filename.'.'.$extension;
        }

        $markers = array('{$file}', '{$ext}');
        $replace = array( $filename, $extension);
        return str_replace($markers, $replace, $name);
    }



    function getThumbSizes(&$model, $size = null) {

        extract($this->settings[$model->name]);

        if ($size) {
            return $thumbsizes[$size];
        }

        return $thumbsizes;
    }

    function initDir(&$model, $dirToCheck = null) {

        extract($this->settings[$model->name]);

        if ($dirToCheck) {

            $dir = $dirToCheck;

        }

        // Check if directory exists and create it if required

        if(!is_dir($dir)) {

            if($create_directory && !$this->Folder->mkdirr($dir)) {

                unset($config[$field]);

                unset($model->data[$model->name][$field]);

            }

        }

        // Check if directory is writable

        if(!is_writable($settings['dir'])) {

            unset($config[$field]);

            unset($model->data[$model->name][$field]);

        }

        // Check that the given directory does not have a DS on the end

        if($settings['dir'][strlen($settings['dir'])-1] == DS) {

            $settings['dir'] = substr($settings['dir'],0,strlen($settings['dir'])-2);

        }

    }


    /**
     * return the cleaned filename (without the file extension)
     *
     * @param object $model
     * @param array $fileValues
     * @param string $string
     * @return string
     */
    function _getFilename($model, $fileValues, $string) {

        extract(am($this->settings[$model->name]['defaultSettings'],$fileValues));

        if ($randomFilenames) {
            return uniqid("");
        }

        $string = htmlentities(low($string), null, 'UTF-8');

        foreach ($nameCleanups as $regex => $replace) {
            if ($regex == 'decode') {
                $string = html_entity_decode($string);
            }
            else {
                $string = preg_replace($regex, $replace, $string);
            }
        }
        return $string;
    }


    /**
     * return the absolute file path
     *
     * @param object $model
     * @param array $fileValues
     * @param string $path
     * @return string
     */
    function _getPath ($model, $fileValues, $path) {

        extract(am($this->settings[$model->name]['defaultSettings'],$fileValues));

        if (strpos($path,'{') === false) {
            return $path;
        }

        $markers = array('{APP}', '{DS}', '{IMAGES}', '{WWW_ROOT}', '{FILES}');

        $replace = array( APP, DS, IMAGES, WWW_ROOT, WWW_ROOT.'files'.DS );

        $folderPath = str_replace ($markers, $replace, $path);

        new Folder ($folderPath, true);

        return $folderPath;

    }

    //validation function

    /**
     * Validate an uploaded file
     *
     * @return boolean
     */
    function validateUploadedFile($model) {
        $eachArray = null;
        $upload_info = ($model->data[$model->name]);
        $eachArray = each($model->validate);
        reset($model->validate);
        $field = $eachArray[0];

        $eachArray = each($model->validate);
        reset($model->validate);

        $upload_info = $upload_info[$field];
        if(!is_array($upload_info)) return true;
        if ($upload_info['error'] == 4) {
            return true;
        }
        if ($upload_info['error'] !== 0) {
            return false;
        }
        return is_uploaded_file($upload_info['tmp_name']);
    }

    /**
     * Check the file extension of an uploaded file
     *
     * @param unknown_type $data
     * @param unknown_type $extensions
     * @return unknown
     */
    function validateFileExtension($model, $data, $extensions) {
        $eachArray = null;
        $upload_info = ($model->data[$model->name]);

        $eachArray = each($model->validate);
        reset($model->validate);

        $field = $eachArray[0];
        $upload_info = $upload_info[$field];


        if(!is_array($upload_info)) {
            return true;
        }
        if($upload_info['error']==4) {
            return true;
        }
        $filename = low($upload_info['name']);
        $ext = end(explode('.', $filename));
        return in_array($ext, $extensions);
    }

    /**
     * Check the file size of an uploaded file
     *
     * @param unknown_type $data
     * @param unknown_type $extensions
     * @return unknown
     */
    function maxFileSize($model, $data, $fileSize) {
        $upload_info = ($model->data[$model->name]);
        $eachArray = each($model->validate);
        reset($model->validate);
        $field =$eachArray[0];
        $upload_info = $upload_info[$field];

        if ($upload_info['size'] > $fileSize) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Validate an uploaded file
     *
     * @return boolean
     */
    function requiredFile($model, $required = true) {
        $eachArray = null;
        $upload_info = ($model->data[$model->name]);
        $eachArray = each($model->validate);
        reset($model->validate);
        $field = $eachArray[0];

        $eachArray = each($model->validate);
        reset($model->validate);

        $upload_info = $upload_info[$field];
        if(!is_array($upload_info) && $required) return false;
        if ($upload_info['error'] == 4 && $required) {
            return false;
        }
        if ($upload_info['error'] !== 0) {
            return false;
        }
        if ($upload_info['size'] == 0) {
            return false;
        }
        return true;
    }

}
?>