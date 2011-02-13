<?php
/**
 * PHP version 5
 *
 * dirnonline:  Dynamic Web Development (sm) (http://www.dirnonline.com/)
 * Copyright 2009, dirnonline (http://www.dirnonline.com/)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2009, dirnonline (http://www.dirnonline.com/)
 * @link          
 * @package       dirnonline
 * @subpackage    dirnonline.datasource
 * @version       1.0
 * @modifiedby    DiRN
 * @lastmodified  2009-05-12 08:52:00 -0400 (Tues, 12 May 2009)
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

/**
 * Use DboEmpty as an empty datasource
 *
 * DboEmpty allows you to use CakePHP without a datasource
 *
 * @package       dirnonline
 * @subpackage    dirnonline.datasource
 * @link          
 */
	class DboEmpty extends DboSource {
		function connect() {
			$this->connected = true;
			return true;
		}

		function disconnect() {
			$this->connected = false;
			return true;
		}
	}