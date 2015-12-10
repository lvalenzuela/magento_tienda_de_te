<?php 
include("conexion.php");

$trs_transaccion = $_POST['TBK_TIPO_TRANSACCION'];
$trs_respuesta = $_POST['TBK_RESPUESTA'];
$trs_orden_compra = $_POST['TBK_ORDEN_COMPRA'];
$trs_id_session = $_POST['TBK_ID_SESION'];
$trs_cod_autorizacion = $_POST['TBK_CODIGO_AUTORIZACION'];
$trs_monto = substr($_POST['TBK_MONTO'],0,-2).".00";
$trs_nro_final_tarjeta = $_POST['TBK_FINAL_NUMERO_TARJETA'];
$trs_fecha_expiracion = $_POST['TBK_FECHA_EXPIRACION'];
$trs_fecha_contable = $_POST['TBK_FECHA_CONTABLE'];
$trs_fecha_transaccion = $_POST['TBK_FECHA_TRANSACCION'];
$trs_hora_transaccion = $_POST['TBK_HORA_TRANSACCION'];
$trs_id_transaccion = $_POST['TBK_ID_TRANSACCION'];
$trs_tipo_pago = $_POST['TBK_TIPO_PAGO'];
$trs_nro_cuotas = $_POST['TBK_NUMERO_CUOTAS'];
$trs_mac = $_POST['TBK_MAC'];
//$trs_monto_cuota = $_POST['TBK_MONTO_CUOTA'];
$trs_tasa_interes_max = $_POST['TBK_TASA_INTERES_MAX'];

//$resto = substr($trs_monto, 0, -2);

/**** inicio de pagina de cierre xt_compra.php***/ 

 if($trs_respuesta==0)
{ 
//**** validacion de mac ****/
  
  $filename = "/home/ubuntu/magento-tienda-de-te/cgi-bin/log/log".$trs_id_transaccion.".txt";
$fp=fopen($filename,"w");
reset($_POST);
while (list($key,$val) = each($_POST))
	{
		fwrite($fp,"$key=$val&");
	}
	fclose($fp);

/* 2.- Invocar a tbk_check_mac (Que en realidad no es una cgi) usando como parámetro el archivo generado */

$cmdline = "home/ubuntu/magento-tienda-de-te/cgi-bin/tbk_check_mac.cgi $filename";
exec($cmdline,$result,$retint);
    /*Si $result[0]="CORRECTO" , entonces mac válido*/
    if($result[0]=="CORRECTO")
     { 
	
      
 /**** Comprobacion de Orden de Compra ****/
      $query_RS_Busca = "select * from webpaypagos where TBK_ORDEN_COMPRA='".$trs_orden_compra."' order by TBK_ORDEN_COMPRA DESC Limit 1";
      $RS_Busca = mysql_query($query_RS_Busca, $conexion) or die(mysql_error());
      $row_RS_Busca = mysql_fetch_assoc($RS_Busca);
      $totalRows_RS_Busca = mysql_num_rows($RS_Busca);
      $theValue = ($totalRows_RS_Busca>1) ? "RECHAZADO" : "ACEPTADO";
      if ($theValue=="ACEPTADO")
      {  
         /**** Comprobacion de Monto ****/
		 $query_RS_Montos = "select * from webpaypagos where TBK_ORDEN_COMPRA='".$trs_orden_compra."'  Order by TBK_ORDEN_COMPRA DESC Limit 1" ;
         $RS_Montos = mysql_query($query_RS_Montos, $conexion) or die(mysql_error());
         $row_RS_Montos = mysql_fetch_assoc($RS_Montos);
         $totalRows_RS_Montos = mysql_num_rows($RS_Montos);
         $theValue = ($trs_monto!=$row_RS_Montos['TBK_MONTO']) ? "RECHAZADO" : "ACEPTADO"; 
      if ($theValue=="ACEPTADO")
       {   
           $sql="insert into webpay (Tbk_tipo_transaccion, Tbk_respuesta, Tbk_orden_compra, Tbk_id_sesion, Tbk_codigo_autorizacion, Tbk_monto, Tbk_Final_numero_Tarjeta, Tbk_fecha_expiracion, Tbk_fecha_contable, Tbk_fecha_transaccion, Tbk_hora_transaccion, Tbk_id_transaccion, Tbk_tipo_pago, Tbk_numero_cuotas, Tbk_mac, Tbk_tasa_interes_max,Tbk_ip)
	Values ('".$trs_transaccion."','".$errors."','".$trs_orden_compra."','".$trs_id_session."','".$trs_cod_autorizacion."','".$trs_monto."','".$trs_nro_final_tarjeta."','".$trs_fecha_expiracion."','".$trs_fecha_contable."','".$trs_fecha_transaccion."','".$trs_hora_transaccion."','".$trs_id_transaccion."','".$trs_tipo_pago."','".$trs_nro_cuotas."','".$trs_mac."','".$trs_tasa_interes_max."','".$_SERVER['REMOTE_ADDR']."')";


            $RS_Ingresa = mysql_query($sql, $conexion) or die(mysql_error());   
	 	 
		}
        else
        {
		echo "RECHAZADO";
		return;
        } 
		 /**** fin Comprobacion de Montos ****/ 
		 
	  }
      else
      {
      echo "RECHAZADO";

      }  
	   /*** fin Comprobacion de Orden de Compra ****/
	 echo "ACEPTADO";
     } 
     else
     { 
      echo "RECHAZADO";
	  return;
     } 
 /****fin Validacion MAC ****/
 }
else
{ 
  echo "ACEPTADO";
}
 
/**** Fin de pagina de Cierre ****/

 ?>
