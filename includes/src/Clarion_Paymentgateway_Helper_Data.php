<?php

class Clarion_Paymentgateway_Helper_Data extends Mage_Core_Helper_Abstract
{

public function getPaymentmethodPaymentgatewayurl()
{
return Mage::getStoreConfig("payment/paymentgateway/cgi_url");
}
   
    
}