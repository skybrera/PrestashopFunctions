<?php


namespace Devster\Prestaservice;


use Devster\Prestaservice\PrestaShopWebservice;
use Devster\Prestaservice\PrestaShopWebserviceException;



// Prima della suddivisione delle due classi contenute di PSWebServiceLibrary
// in PrestaShopWebservice e PrestaShopWebserviceException per includere
// la libreria ufficiale dovevo utilizzare "require_once 'PSWebServiceLibrary.php';"


class PrestashopFunctions
{


  protected $prestashop_url;
  protected $webservice_key;
  protected $debug;




  function __construct( String $prestashop_url, String $webservice_key, bool $debug = true ){
    $this->prestashop_url = $prestashop_url;
    $this->webservice_key = $webservice_key;
    $this->debug          = $debug;
  }





  public function updateOrder( int $order_id, int $order_state ): void{

      try {
          // creating webservice access
          $webService = new PrestaShopWebservice( $this->prestashop_url, $this->webservice_key, $this->debug );

          // call to retrieve customer with ID 2
          $xml = $webService->get([
              'resource' => 'orders',
              'id' => $order_id, // Here we use hard coded value but of course you could get this ID from a request parameter or anywhere else
          ]);

          // print_r( $xml );

          $orderFields = $xml->order->children();
          $orderFields->current_state = $order_state;
          // print_r( $customerFields );

      	$updatedXml = $webService->edit([
      	    'resource' => 'orders',
      	    'id' => (int) $orderFields->id,
      	    'putXml' => $xml->asXML(),
      	]);
      	$orderFields = $updatedXml->order->children();
      	// echo 'order updated with ID ' . $orderFields->id . PHP_EOL;
          // $response = json_encode( array( 'response' => 'order ' . $id_order . ' updated with Status ' . $orderState ) );
          // echo $response;


      } catch ( \PrestaShopWebserviceException $ex ) {
          // Shows a message related to the error
          // echo 'Other error: <br />' . $ex->getMessage();
      }

  }






  public function updateProduct( int $order_id, Array $parameters ): void{
      try{
           $webService = new PrestaShopWebservice( $this->prestashop_url, $this->webservice_key, $this->debug );
           $opt        = array( 'resource' => 'products','id' => $id_presta );

           $xml        = $webService->get( $opt );
           $resources  = $xml->children()->children();


           unset( $xml->children()->children()->manufacturer_name );
           unset( $xml->children()->children()->position_in_category );
           unset( $xml->children()->children()->quantity );
           unset( $xml->children()->children()->type );





           if ( $unita_vendita != '0.000000' ) {
             $prezzo_per_unita = ( $prezzo_tasse_escluse / 10 ) * $unita_vendita;
             // $prezzo_vendita = round( $prezzo_unitario * $peso, 3 );
             $riepilogo = " $prezzo_per_unita " . " €/$formato ";


             $resources->id_tax_rules_group  = $id_iva;
             $resources->active              = $attivo;
             $resources->price               = $prezzo_per_unita;
             $resources->description_short   = $riepilogo;
           }else {
             // $prezzo_vendita                 = round( $prezzo_vendita/$div_iva,3 );
             // $resources->weight              = $peso;
             $riepilogo = " $prezzo_pubblico " . " al pezzo ";


             $resources->id_tax_rules_group  = $id_iva;
             $resources->active              = $attivo;
             $resources->price               = $prezzo_tasse_escluse;
             $resources->description_short   = $riepilogo;
           }



           $opt                            = array( 'resource' => 'products','id' => $id_presta );
           $opt['putXml']                  = $xml->asXML();
           $xml                            = $webService->edit( $opt );
           fwrite( $f_log, "$id aggiornato correttamente! \n" );
       }
       catch ( PrestaShopWebserviceException $e ){
           echo "errore<br>";
           // Here we are dealing with errors
           $trace = $e->getTrace();
           if ( $trace[0]['args'][0] == 404 ) echo 'Bad ID';
           else if ( $trace[0]['args'][0] == 401 ) echo 'Bad auth key';
           else echo 'Other error<br />' . $e->getMessage();
       }
  }

































}
