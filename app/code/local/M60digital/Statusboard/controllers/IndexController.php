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

class M60digital_Statusboard_IndexController extends Mage_Core_Controller_Front_Action{
	
	public function IndexAction() {

		$this->loadLayout();   

		$this->renderLayout();
		
		$helper = Mage::helper('statusboard/data');
		
		$helper->authenticate();

	}

}