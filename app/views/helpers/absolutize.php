<?php
class AbsolutizeHelper extends Helper {

    /*
     * rende assoluti i link relativi inseriti nel testo
     */
    function links($text)
    {
        //preg_match_all("/(a[* ]*href=[\"|'])([^http|ftp|https][a-zA-Z0-9\-\_\.\/:]+)([\"|'])/", $text, $links);
        $text = preg_replace("/(href=[\"|'])([^http|ftp|https][a-zA-Z0-9\-\_\.\/:]+)([\"|'])/", "$1http://".$_SERVER['HTTP_HOST']."$2$3", $text);
        return $text;
    }

    function images($text)
    {
        $matches = array ();
        if (preg_match_all('/<img[^>]* src=\"([^\"]*)\"[^>]*>/', $text, $matches))
        {
            for ($i = 0; $i < count($matches[0]); $i++)
            {
                $full_www_root = 'http://'.$_SERVER['HTTP_HOST'];
                $file = str_replace($this->webroot($matches[1][$i]), WWW_ROOT, $matches[1][$i]);

                $file = $full_www_root . $file;
                $file = str_replace($matches[1][$i], $file, $matches[0][$i]);
                $text = str_replace($matches[0][$i], $file, $text);
            }
        }
        return $text;
    }
}