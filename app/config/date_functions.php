<?php

function isDefaultLanguage() {
    if(Configure::read('language') == Configure::read('default_language'))
        return true;
    else return false;
}

function digi_date($date)
{
    //non stampo nulla se la data è 0000-00-00
    if($date == '0000-00-00'
        || $date == '0000-00-00 00:00'
        || empty($date)) {
        return '';
    }

    $format = Configure::read('date.format');

    $ts = strtotime($date);

    $language = Configure::read('Config.language');

    switch($language) {
        case 'en':
            return date($format, $ts);
            break;
        default:
            return date_translate($format, $ts);
            break;
    }
}

function date_translate($format, $ts = null) {

		//non stampo nulla se la data è 0000-00-00
        if( $ts == strtotime('0000-00-00') ) return '';
        if( $ts == strtotime('0000-00-00 00:00') ) return '';

        if ($ts == null) $ts = time();
        $data = date($format, $ts);

        // Giorni della settimana contratti
        if (eregi('Mon[^d]', $data)) {
            $data = eregi_replace('Mon', __('Mon', true), $data);
        } elseif (eregi('Tue[^s]', $data)) {
            $data = eregi_replace('Tue', __('Tue', true), $data);
        } elseif (eregi('Wed[^n]', $data)) {
            $data = eregi_replace('Wed', __('Wed', true), $data);
        } elseif (eregi('Thu[^r]', $data)) {
            $data = eregi_replace('Thu', __('Thu', true), $data);
        } elseif (eregi('Fri[^d]', $data)) {
            $data = eregi_replace('Fri', __('Fri', true), $data);
        } elseif (eregi('Sat[^u]', $data)) {
            $data = eregi_replace('Sat', __('Sat', true), $data);
        } elseif (eregi('Sun[^d]', $data)) {
            $data = eregi_replace('Sun', __('Sun', true), $data);
        }

        // Giorni della settimana estesi
        if (eregi('Monday', $data)) {
            $data = eregi_replace('Monday', __('Monday', true), $data);
        } elseif (eregi('Tuesday', $data)) {
            $data = eregi_replace('Tuesday', __('Tuesday', true), $data);
        } elseif (eregi('Wednesday', $data)) {
            $data = eregi_replace('Wednesday', __('Wednesday', true), $data);
        } elseif (eregi('Thursday', $data)) {
            $data = eregi_replace('Thursday', __('Thursday', true), $data);
        } elseif (eregi('Friday', $data)) {
            $data = eregi_replace('Friday', __('Friday', true), $data);
        } elseif (eregi('Saturday', $data)) {
            $data = eregi_replace('Saturday', __('Saturday', true), $data);
        } elseif (eregi('Sunday', $data)) {
            $data = eregi_replace('Sunday', __('Sunday', true), $data);
        }

        // Mesi contratti
        if (eregi('Jan[^u]', $data)) {
            $data = eregi_replace('Jan', __('Jan', true), $data);
        } elseif (eregi('May', $data)) {
            if (eregi('M', $format)) {
                $data = eregi_replace('May', __('May', true), $data);
            }
        } elseif (eregi('Jun[^e]', $data)) {
            $data = eregi_replace('Jun', __('Jun', true), $data);
        } elseif (eregi('Jul[^y]', $data)) {
            $data = eregi_replace('Jul', __('Jul', true), $data);
        } elseif (eregi('Aug[^u]', $data)) {
            $data = eregi_replace('Aug', __('Aug', true), $data);
        } elseif (eregi('Sep[^t]', $data)) {
            $data = eregi_replace('Sep', __('Sep', true), $data);
        } elseif (eregi('Oct[^o]', $data)) {
            $data = eregi_replace('Oct', __('Oct', true), $data);
        } elseif (eregi('Dec[^e]', $data)) {
            $data = eregi_replace('Dec', __('Dec', true), $data);
        }

        // Mesi estesi
        if (eregi('January', $data)) {
            $data = eregi_replace('January', __('January', true), $data);
        } elseif (eregi('February', $data)) {
            $data = eregi_replace('February', __('February', true), $data);
        } elseif (eregi('March', $data)) {
            $data = eregi_replace('March', __('March', true), $data);
        } elseif (eregi('April', $data)) {
            $data = eregi_replace('April', __('April', true), $data);
        } elseif (eregi('May', $data)) {
            if (eregi('F', $format)) {
                $data = eregi_replace('May', __('May', true), $data);
            }
        } elseif (eregi('June', $data)) {
            $data = eregi_replace('June', __('June', true), $data);
        } elseif (eregi('July', $data)) {
            $data = eregi_replace('July', __('July', true), $data);
        } elseif (eregi('August', $data)) {
            $data = eregi_replace('August', __('August', true), $data);
        } elseif (eregi('September', $data)) {
            $data = eregi_replace('September', __('September', true), $data);
        } elseif (eregi('October', $data)) {
            $data = eregi_replace('October', __('October', true), $data);
        } elseif (eregi('November', $data)) {
            $data = eregi_replace('November', __('November', true), $data);
        } elseif (eregi('December', $data)) {
            $data = eregi_replace('December', __('December', true), $data);
        }

        return $data;
}

// traduce in italiano la data
function date_it($format, $ts = null) {

    //non stampo nulla se la data è 0000-00-00
    if( $ts == strtotime('0000-00-00') ) return '';

    if ($ts == null) $ts = time();
    $data = date($format, $ts);

    // Giorni della settimana contratti
    if (eregi('Mon[^d]', $data)) {
        $data = eregi_replace('Mon', 'Lun', $data);
    } elseif (eregi('Tue[^s]', $data)) {
        $data = eregi_replace('Tue', 'Mar', $data);
    } elseif (eregi('Wed[^n]', $data)) {
        $data = eregi_replace('Wed', 'Mer', $data);
    } elseif (eregi('Thu[^r]', $data)) {
        $data = eregi_replace('Thu', 'Gio', $data);
    } elseif (eregi('Fri[^d]', $data)) {
        $data = eregi_replace('Fri', 'Ven', $data);
    } elseif (eregi('Sat[^u]', $data)) {
        $data = eregi_replace('Sat', 'Sab', $data);
    } elseif (eregi('Sun[^d]', $data)) {
        $data = eregi_replace('Sun', 'Dom', $data);
    }

    // Giorni della settimana estesi
    if (eregi('Monday', $data)) {
        $data = eregi_replace('Monday', 'Lunedi', $data);
    } elseif (eregi('Tuesday', $data)) {
        $data = eregi_replace('Tuesday', 'Martedi', $data);
    } elseif (eregi('Wednesday', $data)) {
        $data = eregi_replace('Wednesday', 'Mercoledi', $data);
    } elseif (eregi('Thursday', $data)) {
        $data = eregi_replace('Thursday', 'Giovedi', $data);
    } elseif (eregi('Friday', $data)) {
        $data = eregi_replace('Friday', 'Venerdi', $data);
    } elseif (eregi('Saturday', $data)) {
        $data = eregi_replace('Saturday', 'Sabato', $data);
    } elseif (eregi('Sunday', $data)) {
        $data = eregi_replace('Sunday', 'Domenica', $data);
    }

    // Mesi contratti
    if (eregi('Jan[^u]', $data)) {
        $data = eregi_replace('Jan', 'Gen', $data);
    } elseif (eregi('May', $data)) {
        if (eregi('M', $format)) {
            $data = eregi_replace('May', 'Mag', $data);
        }
    } elseif (eregi('Jun[^e]', $data)) {
        $data = eregi_replace('Jun', 'Giu', $data);
    } elseif (eregi('Jul[^y]', $data)) {
        $data = eregi_replace('Jul', 'Lug', $data);
    } elseif (eregi('Aug[^u]', $data)) {
        $data = eregi_replace('Aug', 'Ago', $data);
    } elseif (eregi('Sep[^t]', $data)) {
        $data = eregi_replace('Sep', 'Set', $data);
    } elseif (eregi('Oct[^o]', $data)) {
        $data = eregi_replace('Oct', 'Ott', $data);
    } elseif (eregi('Dec[^e]', $data)) {
        $data = eregi_replace('Dec', 'Dic', $data);
    }

    // Mesi estesi
    if (eregi('January', $data)) {
        $data = eregi_replace('January', 'Gennaio', $data);
    } elseif (eregi('February', $data)) {
        $data = eregi_replace('February', 'Febbraio', $data);
    } elseif (eregi('March', $data)) {
        $data = eregi_replace('March', 'Marzo', $data);
    } elseif (eregi('April', $data)) {
        $data = eregi_replace('April', 'Aprile', $data);
    } elseif (eregi('May', $data)) {
        if (eregi('F', $format)) {
            $data = eregi_replace('May', 'Maggio', $data);
        }
    } elseif (eregi('June', $data)) {
        $data = eregi_replace('June', 'Giugno', $data);
    } elseif (eregi('July', $data)) {
        $data = eregi_replace('July', 'Luglio', $data);
    } elseif (eregi('August', $data)) {
        $data = eregi_replace('August', 'Agosto', $data);
    } elseif (eregi('September', $data)) {
        $data = eregi_replace('September', 'Settembre', $data);
    } elseif (eregi('October', $data)) {
        $data = eregi_replace('October', 'Ottobre', $data);
    } elseif (eregi('November', $data)) {
        $data = eregi_replace('November', 'Novembre', $data);
    } elseif (eregi('December', $data)) {
        $data = eregi_replace('December', 'Dicembre', $data);
    }

    return $data;
}