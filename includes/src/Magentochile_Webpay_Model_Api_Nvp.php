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
class Magentochile_Webpay_Model_Api_Nvp extends Magentochile_Webpay_Model_Api_Abstract{

 public function getVersion(){

  return '0.1.0';

 }



 public function callGetTransactionDetails(){

  $nvpArr = array(

   'TRANSACTIONID' => $this->getTransactionId(),

 );



 $resArr = $this->call('GetTransactionDetails', $nvpArr);



 if (false===$resArr){

  return false;

 }



 $this->setPayerEmail($resArr['RECEIVEREMAIL']);

 $this->setPayerId($resArr['PAYERID']);

 $this->setFirstname($resArr['FIRSTNAME']);

 $this->setLastname($resArr['LASTNAME']);

 $this->setTransactionId($resArr['TRANSACTIONID']);

 $this->setParentTransactionId($resArr['PARENTTRANSACTIONID']);

 $this->setCurrencyCode($resArr['CURRENCYCODE']);

 $this->setAmount($resArr['AMT']);

 $this->setPaymentStatus($resArr['PAYERSTATUS']);

 return $resArr;

}



 public function deformatNVP($nvpstr){

  $intial=0;

  $nvpArray = array();

  $nvpstr = strpos($nvpstr, "\r\n\r\n")!==false ? substr($nvpstr, strpos($nvpstr, "\r\n\r\n")+4) : $nvpstr;



  while(strlen($nvpstr)) {

   $keypos= strpos($nvpstr,'=');

   $valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);

   $keyval=substr($nvpstr,$intial,$keypos);

   $valval=substr($nvpstr,$keypos+1,$valuepos-$keypos-1);

   $nvpArray[urldecode($keyval)] =urldecode( $valval);

   $nvpstr=substr($nvpstr,$valuepos+1,strlen($nvpstr));

  }

  return $nvpArray;

 }



}

?>