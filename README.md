# Prestashop Functions

  Useful functions for Prestashop Webservice



## MODIFICHE AL FILE *PSWebServiceLibrary.php*


  Attualmente PrestaShop ha alcuni problemi legati alla cattiva gestione dei namespace, causa il passaggio da una piattaforma in cui i file venivano gestiti esclusivamente tramite "include" e "require".

  Per eliminare questi problemi ed uniformare il package ho aggiunto alla libreria ufficiale del team (PSWebServiceLibrary.php) le seguenti modifiche:

   - namespace Devster\Prestaservice;
   - In fondo la riga
      class PrestaShopWebserviceException extends Exception { }
        diventa
      class PrestaShopWebserviceException extends \Exception { }
      per accedere alla classe Exception nativa di Php
