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
class Magentochile_Webpay_Model_Source_PaymentCountry{

 protected $_options;

 public function toOptionArray(){

  return $options = array(

  'AR' => 'Argentina', 

  'BR' => 'Brasil',

  'CL' => 'Chile',

  'MX' => 'México'

	 );

 } 

}

?>