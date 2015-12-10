<?php

$installer = $this;



$installer->startSetup();



$installer->run("



-- DROP TABLE IF EXISTS `{$this->getTable('webpay_api_debug')}`;

CREATE TABLE `{$this->getTable('webpay_api_debug')}` (

  `debug_id` int(10) unsigned NOT NULL auto_increment,

  `debug_at` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,

  `request_body` text,

  `response_body` text,

  PRIMARY KEY  (`debug_id`),

  KEY `debug_at` (`debug_at`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- DROP TABLE IF EXISTS `{$this->getTable('webpaypagos')}`;

CREATE TABLE `{$this->getTable('webpaypagos')}` (

  `webpaypagosID` int(7) NOT NULL AUTO_INCREMENT,
  `tienda` int(2) NOT NULL DEFAULT '0',
  `TBK_MONTO` varchar(10) NOT NULL DEFAULT '',
  `TBK_ORDEN_COMPRA` varchar(40) NOT NULL DEFAULT '',
  `TBK_ID_SESION` varchar(40) NOT NULL DEFAULT '',
  `PRODUCTO` varchar(260) NOT NULL,
  `usr_nombre` text NOT NULL,
  `usr_apellido` text NOT NULL,
  `usr_email` text NOT NULL,
  `envio` text NOT NULL,
  `costo_envio` text NOT NULL,
  `costo_producto` text NOT NULL,
  PRIMARY KEY (`webpaypagosID`),
  KEY `tienda` (`tienda`),
  KEY `webpaypagosID` (`webpaypagosID`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- DROP TABLE IF EXISTS `{$this->getTable('webpay')}`;
CREATE TABLE `{$this->getTable('webpay')}` (

 `webpay_id` int(10) NOT NULL auto_increment,
 `Tbk_Orden_Compra` varchar(30) NOT NULL default '',
 `Tbk_Codigo_Comercio` varchar(12) default NULL,
 `Tbk_Codigo_Comercio_Enc` varchar(255) default NULL,
 `Tbk_Tipo_Transaccion` varchar(50) NOT NULL default '',
 `Tbk_Respuesta` int(2) NOT NULL default '0',
 `Tbk_Monto` int(10) NOT NULL default '0',
 `Tbk_Codigo_Autorizacion` varchar(6) NOT NULL default '0',
 `Tbk_Numero_Tarjeta` varchar(19) NOT NULL default '0',
 `Tbk_Final_numero_Tarjeta` varchar(4) NOT NULL default '0',
 `Tbk_Fecha_Expiracion` varchar(6) NOT NULL default '',
 `Tbk_Fecha_Contable` varchar(4) NOT NULL default '',
 `Tbk_Fecha_Transaccion` varchar(8) NOT NULL default '',
 `Tbk_Hora_Transaccion` varchar(6) NOT NULL default '',
 `Tbk_Id_Sesion` varchar(40) NOT NULL default '',
 `Tbk_Id_Transaccion` int(20) NOT NULL default '0',
 `Tbk_Tipo_Pago` char(2) NOT NULL default '',
 `Tbk_Numero_Cuotas` char(2) NOT NULL default '0',
 `Tbk_Tasa_Interes_Max` int(4) NOT NULL default '0',
 `Tbk_Mac` varchar(32) NOT NULL default '',
 `TBK_VCI` varchar(20) default NULL,
 `Tbk_ip` varchar(255) NOT NULL,
 `FechaCompleta` datetime default NULL,
 PRIMARY KEY  (`webpay_id`),
 KEY `webpay_id` (`webpay_id`),
 KEY `Tbk_Id_Sesion` (`Tbk_Id_Sesion`),
 KEY `Tbk_Id_Transaccion` (`Tbk_Id_Transaccion`),
 KEY `Tbk_Orden_Compra` (`Tbk_Orden_Compra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;







    ");



$installer->endSetup();



$installer->addAttribute('quote_payment', 'webpay_payer_id', array());

$installer->addAttribute('quote_payment', 'webpay_payer_status', array());

$installer->addAttribute('quote_payment', 'webpay_correlation_id', array());

