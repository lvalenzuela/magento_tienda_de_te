<?php
/**
 * Magentochile_Webpay extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Payment
 * @package    Magentochile_Webpay
 * @copyright  Copyright (c) 2013 Magento Chile LLC
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * @category   Payment
 * @package    Magentochile_Webpay
 * @author     Boris Duran R. <bduran@magentochile.cl>
 */
abstract class Magentochile_Webpay_Model_Abstract extends Mage_Payment_Model_Method_Abstract{

 public function getApi(){

  return Mage::getSingleton('webpay/api_nvp');

 }



 public function getSession(){

  return Mage::getSingleton('webpay/session');

 }



 public function getCheckout(){

  return Mage::getSingleton('checkout/session');

 }



 public function getQuote(){

  return $this->getCheckout()->getQuote();

 }



 public function getRedirectUrl(){

  return $this->getApi()->getRedirectUrl();

 }



 public function getCountryRegionId(){

  $a = $this->getApi()->getShippingAddress();

  return $this;

 }

	

}