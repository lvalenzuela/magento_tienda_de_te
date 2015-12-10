<?php

class Magentochile_Webpay_Model_Observer {


public function cancelPendingOrders(){

$orderCollection = Mage::getResourceModel('sales/order_collection');

$orderCollection
->addFieldToFilter('state', 'pending_payment')
->addFieldToFilter('created_at', array('lt' => new Zend_Db_Expr("DATE_ADD('".now()."', INTERVAL -'01:00' HOUR_MINUTE)")))
->getSelect()
->order('e.entity_id')
->limit(10);

$orders ="";
foreach($orderCollection->getItems() as $order)
{
$orderModel = Mage::getModel('sales/order');
$orderModel->load($order['entity_id']);

if(!$orderModel->canCancel())
continue;

$orderModel->cancel();
//$orderModel->setStatus('canceled_pendings');
$orderModel->setStatus('canceled_pendings');
$orderModel->save();

}



}// function



}// end class











?>