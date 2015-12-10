<?php

$hostname = "localhost";
$database = "magento";
$username = "kongo_developer";
$password = "i1dont2know3";
$conexion = mysql_connect($hostname, $username, $password);
mysql_select_db($database ,$conexion) or die("Error seleccionando la base de datos."); 
mysql_query("SET NAMES 'utf8'");//esta función pone los acentos y eñes en la base de datos
$sql_webpaypagos = "SELECT * FROM webpaypagos  order by TBK_ORDEN_COMPRA DESC Limit 1";
$sql_webpay = "SELECT * FROM webpay order by TBK_ORDEN_COMPRA DESC Limit 1 ";

//$result_port = mysql_query($sql_port, $conn);
$fechapedido = date("Y-m-d");
$result_webpaypagos = mysql_query($sql_webpaypagos, $conexion);
$result_webpay = mysql_query($sql_webpay, $conexion);

$i=0;
while($myrow_not = mysql_fetch_array($result_webpay))
			{
			$i++;
		     
			 $t_compra=$myrow_not[Tbk_Orden_Compra]; 
			 $t_monto = $myrow_not[Tbk_Monto]; 
			 $tar_final=$myrow_not[Tbk_Final_numero_Tarjeta]; 
			 $cuotas=$myrow_not[Tbk_Numero_Cuotas]; 
			 $autorizacion=$myrow_not[Tbk_Codigo_Autorizacion]; 
		     $pagos=$myrow_not[Tbk_Tipo_Pago]; 
			} //Fin While
	$e=0;		
while($myrow_p = mysql_fetch_array($result_webpaypagos))
			{
			$e++;
		     $costo_producto=$myrow_p[costo_producto];
			 $costo_envio=$myrow_p[costo_envio];
		     $envio=$myrow_p[envio];
			 $t_producto=$myrow_p[PRODUCTO]; 
			 $t_nombre = $myrow_p[usr_nombre]; 
			 $t_apellido=$myrow_p[usr_apellido]; 
			 $t_email=$myrow_p[usr_email];
			 $t_compra_fracaso=$myrow_p[TBK_ORDEN_COMPRA];/*  para rescatar la OC fracasada para webpay 6.0*/ 
					
			} //Fin While
			

$tipo_pago="CREDITO";
switch($pagos){
   case VN:
      $vn = ("Sin Cuotas");
      break;
   case SI:
      $vn= ("Sin Intereses");
      break;
   case VC:
      $vn= ("Cuotas Normales");
      break;
   case CI:
      $vn= ("Cuotas Normales");
      break;
   case VD:
      $vn= ("Sin Intereses");
      $tipo_pago="DEBITO";
      break;
 }  	
?>
