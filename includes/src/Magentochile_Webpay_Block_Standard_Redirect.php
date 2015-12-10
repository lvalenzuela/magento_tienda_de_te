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
class Magentochile_Webpay_Block_Standard_Redirect extends Mage_Core_Block_Abstract{

 protected function _toHtml(){

  $standard = Mage::getModel('webpay/standard');

  $form = new Varien_Data_Form();

  $form->setAction($standard->getWebpayUrl())

   ->setId('webpay_standard_checkout')

   ->setName('webpay_standard_checkout')

   ->setMethod('POST')

   ->setUseContainer(true);

  foreach ($standard->getStandardCheckoutFormFields() as $field=>$value) {

   $form->addField($field, 'hidden', array('name'=>$field, 'value'=>$value));

  }

  $html = '<html><body>';

  $html.= $this->__('Usted sera redirigido en 5 segundos al sitio seguro de webpay.');

  $html.= $form->toHtml();

  $html.= '<script type="text/javascript">document.getElementById("webpay_standard_checkout").submit();</script>';

  $html.= '</body></html>';

  return $html;

 }

}