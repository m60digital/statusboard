<?php
/**
 * M60 Digital
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the M60 Digital EULA that is bundled with
 * this package in the file LICENSE.txt.
 *
 * @category   M60digital
 * @package    M60digital_Statusboard
 * @copyright  Copyright (c) 2012 M60 Digital Ltd (http://www.m60digital.co.uk/)
 * @license    http://www.m60digital.co.uk/
 */

/**
 * Statusboard extension
 *
 * @category   M60digital
 * @package    M60digital_Statusboard
 * @author     Ciaron Walton
 */
 
class M60digital_Statusboard_Helper_Data extends Mage_Core_Helper_Abstract {
	
	function __construct() {
	
	}
	
	public function authenticate() {
				
		$model = Mage::getModel("admin/user");
			
		if(!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
		
			$this->sendUnauthorisedHeaders();
		
		} else {
		
			$username = $_SERVER['PHP_AUTH_USER'];
			
			$password = $_SERVER['PHP_AUTH_PW'];
		
			$user = $model->loadByUsername($username);
			
			if ( !Mage::helper('core')->validateHash($password, $user->getPassword()) ) {
			
				$this->sendUnauthorisedHeaders();
		
			}
			
		}
	
	}	
	
	public function sendUnauthorisedHeaders() {
		
		header('WWW-Authenticate: Basic realm="Restricted area"');
				
		header('HTTP/1.0 401 Unathorized');
				
		echo "Authorization Required.";
				
		exit;
						
	}
	
	public function buildGraphJson($report_title, $report_subtitle, $datapoints, $type, $show_totals = true) {
		
		$dataSequences = array('title' => $report_title, 'datapoints' => $datapoints);
		
		$graph = array('title' => $report_subtitle, 'type' => $type, 'total' => $show_totals, 'datasequences' => array($dataSequences));
		
		$json = array("graph" => $graph);

		return json_encode($json);

	}

}