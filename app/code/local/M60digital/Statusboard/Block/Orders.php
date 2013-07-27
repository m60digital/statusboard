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

class M60digital_Statusboard_Block_Orders extends Mage_Core_Block_Template {
	
	public function getJson() {
		
		date_default_timezone_set('Europe/London');
		
		$from = date('Y-m-d H:i:s', strtotime('-1 day'));
		
		$order_items = Mage::getModel('sales/order')->getCollection()
		->addAttributeToSelect('*')
		->addAttributeToFilter('created_at', array('gt' => $from))
		->load();
		
		$datapoints = array();
		
		for($i = 11; $i > -1 ; $i--){
			
			$hour_from = date("G", strtotime('-' . $i . ' hour'));
																
			$count = 0;
			
			$type = Mage::getStoreConfig('statusboard_options/orders/type');
			
			$display =  Mage::getStoreConfig('statusboard_options/orders/display');
			
			$report_title = "Recent Orders";
			
			$report_subtitle = Mage::app()->getStore()->getName();
						
			foreach($order_items as $item) {
							
				$timestamp = Mage::getModel('core/date')->timestamp(strtotime($item->getCreatedAt()));
						
				$created_at = date("G", $timestamp);
										
				if($created_at == $hour_from) {
					
					if($display == 'count') {
					
						$count = $count + 1;
						
					} else {
						
						$count = $count + $item->getBaseGrandTotal();

					}
										
				}
											
			}
						
			array_push($datapoints, array('title' => $hour_from . ':00', 'value' => $count));
			
		}
		
		return $this->helper('statusboard/data')->buildGraphJson($report_title, $report_subtitle, $datapoints, $type, false);

	}

}