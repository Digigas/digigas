<?php
/**
 * versione 2.0
 * ale
 * - corretto il path, ora più stabile
 * - aggiunta funzionalità aspect => 'resizeCrop': ridimensiona l'immagine nelle dimensioni richieste senza deformarla
 *      basato sull'helper Image
 */
/**
 * @version 1.1
 * @author Josh Hundley
 * @author Jorge Orpinel <jop@levogiro.net> (changes)
 */
class ImageHelper extends Helper
{
  var $helpers = array('Html');
  var $cacheDir = 'imagecache'; // relative to 'img'.DS

  /**
   * Automatically resizes an image and returns formatted IMG tag
   *
   * @param string $path Path to the image file, relative to the webroot/img/ directory.
   * @param integer $width Image of returned image
   * @param integer $height Height of returned image
   * @param boolean $aspect Maintain aspect ratio (default: true). true / false / resizeCrop
   * @param array    $htmlAttributes Array of HTML attributes.
   * @param boolean $return Wheter this method should return a value or output it. This overrides AUTO_OUTPUT.
   * @return mixed    Either string or echos the value, depends on AUTO_OUTPUT and $return.
   * @access public
   */
  function resize($path, $width, $height, $aspect = true, $htmlAttributes = array(), $return = false) {
    $types = array(1 => "gif", "jpeg", "png", "swf", "psd", "wbmp"); // used to determine image type
    if(empty($htmlAttributes['alt'])) $htmlAttributes['alt'] = 'thumb';  // Ponemos alt default

    //preso dall'helper html
    if (is_array($path)) {
			$path = $this->url($path);
		} elseif ($path[0] === '/') {
			$path = $this->webroot($path);
		} elseif (strpos($path, '://') === false) {
			if (Configure::read('Asset.timestamp') == true && Configure::read() > 0) {
				$path .= '?' . @filemtime(str_replace('/', DS, WWW_ROOT . IMAGES_URL . $path));
			}
			$path = $this->webroot(IMAGES_URL . $path);
		}

    $fullpath = ROOT.DS.APP_DIR.DS.WEBROOT_DIR;

    $_webrootpath = array_slice(array_diff(
            explode('/', $path),
            explode(DS, ROOT.DS.APP_DIR.DS.WEBROOT_DIR)
        ), 0, -1);
    $url = implode(DS, am(explode(DS, ROOT.DS.APP_DIR.DS.WEBROOT_DIR), $_webrootpath)).DS.basename($path);
    if (!($size = getimagesize($url)))
      return; // image doesn't exist

//    if ($aspect) { // adjust to aspect.
//      if (($size[1]/$height) > ($size[0]/$width))  // $size[0]:width, [1]:height, [2]:type
//      $width = ceil(($size[0]/$size[1]) * $height);
//      else
//      $height = ceil($width / ($size[0]/$size[1]));
//    }

    $prefix = '';
    $startX = 0;
    $startY = 0;

    switch($aspect)
    {
        case false:
            //do nothing
            break;
        case 'resizeCrop':
            $prefix = 'rc';
            $ratioX = $width / $size[0];
            $ratioY = $height / $size[1];

            if ($ratioX < $ratioY) {
                    $startX = round(($size[0] - ($width / $ratioY))/2);
                    $startY = 0;
                    $size[0] = round($width / $ratioY);
                    $size[1] = $size[1];
            } else {
                    $startX = 0;
                    $startY = round(($size[1] - ($height / $ratioX))/2);
                    $size[0] = $size[0];
                    $size[1] = round($height / $ratioX);
            }
            break;
        case true:
        default:
            $prefix = 'r';
            if (($size[1]/$height) > ($size[0]/$width))  // $size[0]:width, [1]:height, [2]:type
                $width = ceil(($size[0]/$size[1]) * $height);
            else
                $height = ceil($width / ($size[0]/$size[1]));
            break;
    }

    $relfile = $this->webroot.'img'.'/'.$this->cacheDir.'/'.$prefix.'_'.$width.'x'.$height.'_'.basename($path); // relative file
    $cachefile = $fullpath.DS.IMAGES_URL.$this->cacheDir.DS.$prefix.'_'.$width.'x'.$height.'_'.basename($path);  // location on server

    if (file_exists($cachefile)) {
      $csize = getimagesize($cachefile);
      $cached = ($csize[0] == $width && $csize[1] == $height); // image is cached
      if (@filemtime($cachefile) < @filemtime($url)) // check if up to date
        $cached = false; 
    } else {
      $cached = false;
    }

    if (!$cached) {
      $resize = ($size[0] > $width || $size[1] > $height) || ($size[0] < $width || $size[1] < $height);
    } else {
      $resize = false;
    }

    if ($resize) {
      $image = call_user_func('imagecreatefrom'.$types[$size[2]], $url);
      if (function_exists("imagecreatetruecolor") && ($temp = imagecreatetruecolor ($width, $height))) {
        imagecopyresampled ($temp, $image, 0, 0, $startX, $startY, $width, $height, $size[0], $size[1]);
      } else {
        $temp = imagecreate ($width, $height);
        imagecopyresized ($temp, $image, 0, 0, $startX, $startY, $width, $height, $size[0], $size[1]);
      }
      call_user_func("image".$types[$size[2]], $temp, $cachefile);
      imagedestroy ($image);
      imagedestroy ($temp);
    }

    return $this->output(sprintf($this->Html->tags['image'], $relfile, $this->Html->_parseAttributes($htmlAttributes, null, '', ' ')), $return);
  }
}