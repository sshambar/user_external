<?php
/**
 * Copyright (c) 2018 David Fullard <dave@theinternetmonkey.com>
 * This file is licensed under the Affero General Public License version 3 or
 * later.
 * See the COPYING-README file.
 */

/**
 * User authentication against a FTP/FTPS server
 *
 * @category Apps
 * @package  UserExternal
 * @author   David Fullard <dave@theinternetmonkey.com>
 * @license  http://www.gnu.org/licenses/agpl AGPL
 * @link     http://github.com/owncloud/apps
 */

 
class OC_User_SSH extends \OCA\user_external\Base {
	private $host;

	/**
	 * Create a new SSH authentication provider
	 *
	 * @param string $host Hostname or IP address of SSH servr
	 */
	public function __construct($host) {
		parent::__construct($host);
		$this->host =$host;
	}

	/**
	 * Check if the password is correct without logging in
	 * Requires the php-ssh2 pecl extension
	 *
	 * @param string $uid      The username
	 * @param string $password The password
	 *
	 * @return true/false
	 */
	public function checkPassword($uid, $password) {
		$connection = ssh2_connect($this->host);
		if (ssh2_auth_password($connection, $uid, $password)) {
			$this->storeUser($uid);
			return $uid;
		} else {
			return false;
		}
	}
}
