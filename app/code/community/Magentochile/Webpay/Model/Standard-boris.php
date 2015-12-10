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
class Magentochile_Webpay_Model_Standard extends Mage_Payment_Model_Method_Abstract{

 protected $_code  = 'webpay_standard';
 protected $_formBlockType = 'webpay/standard_form';
	
 public function getWebpayCurrency(){
	 $currency_code = $this->getQuote()->getBaseCurrencyCode();
	 $WebpayCurrency['CL'] = array('CLP' => 1, 'USD' => 2);
	 return @$WebpayCurrency[Mage::getStoreConfig('webpay/wps/country')][$currency_code];
 }
	
 public function getWebpayUrl(){
  $WebpayAction = array (
    
  /* 'CL' => '/cgi-bin/tbk_bp_pago.cgi'*/
  
  
  
  
  
  //'CL' => '/cgi-bin/tbk_bp_pago.cgi'
  'CL' => 'http://artea.magentochile.cl/cgi-bin/tbk_bp_pago.cgi'
   
  );
  $url = $WebpayAction[Mage::getStoreConfig('webpay/wps/country')];
  return $url;
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

 public function canUseInternal(){
  return false;
 }

 public function canUseForMultishipping(){
  return false;
 }

 public function createFormBlock($name){
  $block = $this->getLayout()->createBlock('webpay/standard_form', $name)
   ->setMethod('webpay_standard')
   ->setPayment($this->getPayment())
   ->setTemplate('Webpay/standard/form.phtml');
  return $block;
 }

 public function validate(){
  parent::validate();
  $currency_code = $this->getQuote()->getBaseCurrencyCode();
	 if(!$this->getWebpayCurrency()){
   Mage::throwException(Mage::helper('webpay')->__('Selected currency code ('.$currency_code.') is not compatabile with Webpay('. Mage::getStoreConfig('webpay/wps/country') .')'));
  }
  return $this;
 }

 public function onOrderValidate(Mage_Sales_Model_Order_Payment $payment){
  return $this;
 }

 public function onInvoiceCreate(Mage_Sales_Model_Invoice_Payment $payment){
	
 }

 public function canCapture(){
  return true;
 }
  public function getOrderPlaceRedirectUrl(){
  return Mage::getUrl('webpay/standard/redirect', array('_secure' => true));
 }

	public function getStandardCheckoutFormFields(){

		if ($this->getQuote()->getIsVirtual()) {
			$a = $this->getQuote()->getBillingAddress();
			$b = $this->getQuote()->getShippingAddress();
		}else{
			$a = $this->getQuote()->getShippingAddress();
			$b = $this->getQuote()->getBillingAddress();
		}

		$currency_code = $this->getWebpayCurrency();
		$businessName = Mage::getStoreConfig('webpay/wps/business_name');
		$storeName = Mage::getStoreConfig('store/system/name');
		$order = Mage::getModel('sales/order');
        $order->loadByIncrementId($this->getCheckout()->getLastRealOrderId()); 
        $customerName = $order->getCustomerName();
        $email = $order->getCustomerEmail();
        $qty = $this->getTotalQty();
        $miproducto = $this->setProductId('hola');
        $customerNombre = $order->getCustomerFirstname();
        $customerApellido = $order->getCustomerLastname();
      



          
           
          
		$ord = $this->getCheckout()->getLastRealOrderId();	
		$amount = $order->getBaseGrandTotal(); 
		$mont = sprintf('%.0f', $amount);
		$shippingMethod  = $order->getShippingDescription();
		$envio = $shippingMethod;
		/*$subtotal = $this->getQuote()->getSubtotal();*/

		
		
				
		
		
		
		
		$pricesubtotal = $order->getSubtotal();
		$costo_producto = sprintf('%.0f', $pricesubtotal);
		
		
		
		
		$pricesenvio = $order->getShippingAmount();
		$costo_envio = sprintf('%.0f', $pricesenvio);
		
		
		
		
		
		
		
		
		
		
		
		
	        $qty = $this->getQtyOrdered()
            - $this->getQtyShipped()
            - $this->getQtyRefunded()
            - $this->getQtyCanceled();
      
		
		
		$usr_nombre = $customerNombre;
		$usr_apellido = $customerApellido;
		$usr_email = $email;
		
		$TIENDA = 1;
				/* Init User Session */
        $session = Mage::getSingleton( 'customer/session' )->isLoggedIn();
        
        
      
       
        
        
		$NombreItem = '';
		//$items = $order->getItemsCollection(); old 28102103
		$items = $order->getAllVisibleItems();
		if($items){
			foreach($items as $x){
				//$NombreItem .= $x->getName() .' (x '. $x->getQtyOrdered()*1 . ') ';
				//$NombreItem .= $x->getName() .' (x '. $x->getQtyOrdered()*1 . ') ' .' (precio unit.: $ '. $x->getPrice()*1 . ') ';
				$NombreItem .= $x->getName() .' (x '. $x->getQtyOrdered()*1 . ') ' .' (precio unit.: $ '. $x->getPrice()*1 . ') ';
			}
		}	

			
$hostname = "64.13.226.39";
$database = "artea";
$username = "artea";
$password = "artea5150";
$conexion = mysql_connect($hostname, $username, $password);
mysql_select_db($database ,$conexion) or die("Error seleccionando la base de datos."); 
mysql_query("SET NAMES 'utf8'");//esta función pone los acentos y eñes en la base de datos
$sql= "INSERT INTO webpaypagos (tienda, TBK_MONTO, TBK_ORDEN_COMPRA, TBK_ID_SESION, PRODUCTO, usr_nombre, usr_apellido, usr_email, envio, costo_envio, costo_producto) VALUES ('".$TIENDA."', '".$mont."', '".$ord."', '".$session."', '".$NombreItem."', '".$usr_nombre."', '".$usr_apellido."', '".$usr_email."', '".$envio."', '".$costo_envio."', '".$costo_producto."')";  

//Ingresado en 17-12-2012 para que al momento de "hackeo por parte de transbank se vaya a página de exito y no muestre duplate entry         
$RS_Ingresa = mysql_query($sql, $conexion); 


if (!$RS_Ingresa ) {
    header('Location: /webpay/standard/cancel', TRUE, 303);
    die('Invalid query: ' . mysql_error());
}	
//Fin ingresado en 17-12-2012 para que al momento de "hackeo por parte de transbank se vaya a página de exito y no muestre duplate entry		
		$sArr = array(

	        'TBK_TIPO_TRANSACCION' => 'TR_NORMAL',
			'TBK_ID_SESION' => Mage::getSingleton( 'customer/session' )->isLoggedIn(),
			'TBK_URL_EXITO' => Mage::getUrl('webpay/standard/success',array('_secure' => true)),
			//'TBK_URL_EXITO' => Mage::getUrl('exito',array('_secure' => true)),
			'TBK_URL_FRACASO' => Mage::getUrl('webpay/standard/cancel',array('_secure' => false)),
			//'TBK_URL_FRACASO' => Mage::getUrl('FRACASO?___store=default',array('_secure' => false)),
			'TBK_ORDEN_COMPRA' => $ord,
			'TBK_MONTO' => sprintf('%.2F', $order->getBaseGrandTotal()),
			
			
	
			'E_Comercio' => Mage::getStoreConfig('webpay/wps/business_account'),
			'NombreItem' => $NombreItem? $NombreItem : $businessName,
			
			'NroItem' => $this->getCheckout()->getLastOrderId(),
			'TipoMoneda' => $currency_code,
			'trx_id' => $this->getCheckout()->getLastOrderId(),
						
			'producto' => $NombreItem,
			
			'usr_tel_numero' => $a->getTelephone(),
			'Mensaje' => 0,
			'DireccionEnvio' => 0,
				
		);
		
		
		
		
		
		
//*************envio de correo formulario con la venta***		


//*************fin envio formulario venta****************
	$logoUrl = Mage::getStoreConfig('webpay/wps/logo_url');
	if($logoUrl){
		$sArr = array_merge($sArr, array(
			'image_url' => $logoUrl
			));
		}

	$sReq = '';
	$rArr = array();
	foreach ($sArr as $k=>$v) {
		$value =  str_replace("&","and",$v);
		$rArr[$k] =  $value;
		$sReq .= '&'.$k.'='.$value;
	}
	
	if ($this->getDebug() && $sReq) {
		$sReq = substr($sReq, 1);
		$debug = Mage::getModel('webpay/api_debug')
		->setApiEndpoint($this->getWebpayUrl())
		->setRequestBody($sReq)
		->save();
	}
	
	 return $rArr;
 }


 public function getDebug(){
  return Mage::getStoreConfig('webpay/wps/debug_flag');
 }

 public function isInitializeNeeded(){
  return true;
 }

 public function initialize($paymentAction, $stateObject){
  $state = Mage_Sales_Model_Order::STATE_PENDING_PAYMENT;
  $stateObject->setState($state);
  $stateObject->setStatus(Mage::getSingleton('sales/order_config')->getStateDefaultStatus($state));
  $stateObject->setIsNotified(false);
  }
}