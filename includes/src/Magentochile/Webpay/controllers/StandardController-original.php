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
class Magentochile_Webpay_StandardController extends Mage_Core_Controller_Front_Action{



 protected $_order;



 public function getOrder(){

  if ($this->_order == null){ }

  return $this->_order;

 }





 protected function _expireAjax(){

  if (!Mage::getSingleton('checkout/session')->getQuote()->hasItems()) {

   $this->getResponse()->setHeader('HTTP/1.1','403 Session Expired');

   exit;

  }

 }



 public function getStandard(){

  return Mage::getSingleton('webpay/standard');

 }



 public function redirectAction(){

  $session = Mage::getSingleton('checkout/session');

  $session->setWebpayStandardQuoteId($session->getQuoteId());

  $this->getResponse()->setBody($this->getLayout()->createBlock('webpay/standard_redirect')->toHtml());

  $session->unsQuoteId();

 }



public function cancelAction(){

/* was elimina el redirect - para refresh de la pagina de cancel*/
        $session = Mage::getSingleton('checkout/session');
        if (!$session->getLastSuccessQuoteId()) {
            $this->_redirect('webpay/standard/cancelview');/*was success action*/
            //$this->refreshPage();
            return;
        }

        $lastQuoteId = $session->getLastQuoteId();
        $lastOrderId = $session->getLastOrderId();
        $lastRecurringProfiles = $session->getLastRecurringProfileIds();
        if (!$lastQuoteId || (!$lastOrderId && empty($lastRecurringProfiles))) {
           $this->_redirect('webpay/standard/cancel');
            //$this->refreshPage();
            return;
        }

        $session->clear();
/* fin was elimina el redirect - para refresh de la pagina de cancel*/

// recupera el stock
$orderCollection = Mage::getResourceModel('sales/order_collection');
        $orderCollection
            ->addFieldToFilter('status', 'pending')
            ->addFieldToFilter('created_at', array('lt' =>  new Zend_Db_Expr("DATE_ADD('".now()."', INTERVAL -'0:01' HOUR_MINUTE)"),
                                            'gt' => new Zend_Db_Expr("DATE_ADD('".now()."', INTERAL -'0:01' HOUR_MINUTE)")));

        foreach($orderCollection->getItems() as $order)
        {
            $orderModel = Mage::getModel('sales/order');
            $orderModel->load($order['entity_id']);

            if(!$orderModel->canCancel())
                continue;

            $orderModel->cancel();
            $orderModel->setStatus('canceled');
            $orderModel->save();
// fin recupera el stock            
            $this->loadLayout();
			$this->renderLayout();

		}

}// end function cancelAction




public function cancelviewAction(){

			$this->loadLayout();
			$this->renderLayout();

}// end function cancelviewAction


public function successAction() {
// codigo para vaciar el carrito
    foreach( Mage::getSingleton('checkout/session')->getQuote()->getItemsCollection() as $item ){
    Mage::getSingleton('checkout/cart')->removeItem( $item->getId() )->save();
}   
// fin codigo para vaciar el carrito




/* was elimina el redirect - para refresh de la pagina de exito*/
        $session = Mage::getSingleton('checkout/session');
        if (!$session->getLastSuccessQuoteId()) {
            $this->_redirect('webpay/standard/cancel');/*was success action*/
            //$this->refreshPage();
            return;
        }
        
        
        

        $lastQuoteId = $session->getLastQuoteId();
        $lastOrderId = $session->getLastOrderId();
        $lastRecurringProfiles = $session->getLastRecurringProfileIds();
        if (!$lastQuoteId || (!$lastOrderId && empty($lastRecurringProfiles))) {
           $this->_redirect('webpay/standard/cancel');
            //$this->refreshPage();
            return;
        }

        $session->clear();
        
/* fin was elimina el redirect - para refresh de la pagina de exito*/

/****************** Auto invoice - State Complete - Envio Correo *************************/
$session = Mage::getSingleton('checkout/session');
$session->setQuoteId($session->getWebpayStandardQuoteId(true));

		if ($session->getLastRealOrderId()) {
			$order = Mage::getModel('sales/order')->loadByIncrementId($session->getLastRealOrderId());

// ingreso el 27-12-2012 para autofacturar una vez que el pedido a sido exitoso		
// Codigo modificado, para llevar el monto pagado a "Total Paid" y no quedara como "Total Due"
	    if ($order->canInvoice()) {
            $invoice = $order->prepareInvoice();

            $invoice->register();            
            $invoice->capture();
            $invoice->getOrder()->setIsInProcess(true);
            $order->setState(Mage_Sales_Model_Order::STATE_COMPLETE, true);
            $transactionSave = Mage::getModel('core/resource_transaction')
                ->addObject($invoice)
                ->addObject($invoice->getOrder())
                ->save();
    } 
    
// fin Codigo modificado, para llevar el monto pagado a "Total Paid" y no quedara como "Total Due"    
// fin de ingreso el 27-12-2012 para autofacturar una vez que el pedido a sido exitoso
		 
   			
//*************envio de correo formulario con la venta***
			$order = new Mage_Sales_Model_Order();
			$incrementId = Mage::getSingleton('checkout/session')->getLastRealOrderId();

			$order->loadByIncrementId($incrementId);

			try
			{
			$order->sendNewOrderEmail();
			} catch (Exception $ex) {  }
//*************fin envio formulario venta****************
}


        $this->loadLayout();
        //$block = $this->getLayout()->createBlock('Mage_Core_Block_Template','webpay',array('template' => 'Webpay/exito.phtml'));
        //$this->getLayout()->getBlock('content')->append($block);
        $this->renderLayout();
    }
    
    
     protected function refreshPage() {
		$this->loadLayout();
        $block = $this->getLayout()->createBlock('Mage_Core_Block_Template','webpay',array('template' => 'Webpay/fracaso.phtml'));
        $this->getLayout()->getBlock('content')->append($block);
        $this->renderLayout();
     
     
     }

}
        
?>