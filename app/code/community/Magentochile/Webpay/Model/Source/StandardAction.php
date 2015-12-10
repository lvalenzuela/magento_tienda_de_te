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
class Magentochile_Webpay_Model_Source_StandardAction{

 public function toOptionArray(){

  return array(

  array('value' => Magentochile_Webpay_Model_Standard::PAYMENT_TYPE_AUTH, 'label' => Mage::helper('webpay')->__('Authorization')),

  array('value' => Magentochile_Webpay_Model_Standard::PAYMENT_TYPE_SALE, 'label' => Mage::helper('webpay')->__('Sale')),

  );

 }

}

?>