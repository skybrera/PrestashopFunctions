<?php

use Skybrera\Prestaservice\PrestashopFunctions;
use Skybrera\Prestaservice\PrestaShopWebservice;


require __DIR__ . '/../vendor/autoload.php';


// $id_order   = //'ORDER ID TO UPDATE ';
// $orderState = //'ORDER STATE TO UPDATE ';
$prestashopParameter = array(
          "prestashop_ws_url" => "http://localhost/prestashop1752/" ,
          "prestashop_ws_key" => "RQWD82W6XV3LGIAAULYXYC3NPMWBFRQB",
          "debug" => true
);


$ps_service = new PrestashopFunctions(
  $prestashopParameter[ 'prestashop_ws_url' ],
  $prestashopParameter[ 'prestashop_ws_key' ],
  $prestashopParameter[ 'debug' ],
);



$ps_service->updateOrder( 8, 6 );
