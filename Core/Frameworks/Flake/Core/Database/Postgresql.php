<?php
#################################################################
#  Copyright notice
#
#  (c) 2012 Jérôme Schneider <mail@jeromeschneider.fr>
#  All rights reserved
#
#  http://flake.codr.fr
#
#  This script is part of the Flake project. The Flake
#  project is free software; you can redistribute it
#  and/or modify it under the terms of the GNU General Public
#  License as published by the Free Software Foundation; either
#  version 2 of the License, or (at your option) any later version.
#
#  The GNU General Public License can be found at
#  http://www.gnu.org/copyleft/gpl.html.
#
#  This script is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU General Public License for more details.
#
#  This copyright notice MUST APPEAR in all copies of the script!
#################################################################

namespace Flake\Core\Database;

class Postgresql extends \Flake\Core\Database {

	protected $oDb = FALSE;	// current DB link
	protected $debugOutput = FALSE;
	protected $store_lastBuiltQuery = TRUE;
	protected $debug_lastBuiltQuery = "";
	protected $sHost = "";
	protected $sDbName = "";
	protected $sUsername = "";
	protected $sPassword = "";

	public function __construct($sHost, $sDbName, $sUsername, $sPassword) {
		$this->sHost = $sHost;
		$this->sDbName = $sDbName;
		$this->sUsername = $sUsername;
		$this->sPassword = $sPassword;
		
		$this->oDb = new \Flake\Core\Database\Postgresql\PDOWrapper(
			'pgsql:host=' . $this->sHost . ';dbname=' . $this->sDbName,
			$this->sUsername,
			$this->sPassword
		);
	}
	
	public function tables() {
		$aTables = array();
		
		$sSql = "SELECT * FROM pg_tables WHERE tablename NOT LIKE 'pg_%'";
		$oStmt = $this->query($sSql);
		
		while(($aRs = $oStmt->fetch()) !== FALSE) {
			$aTables[] = $aRs["tablename"];
		}
		
		asort($aTables);
		reset($aTables);
		return $aTables;
	}
}