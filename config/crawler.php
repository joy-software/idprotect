<?php
return[
 /*
 |--------------------------------------------------------------------------
 | Default Config for the crawler
 |--------------------------------------------------------------------------
 */


  /*
   |--------------------------------------------------------------------------
   |    TimeOut for set of searches started successively
   |--------------------------------------------------------------------------
   |
   | Maximum time to execute a search or set of searches started successively.
   | In second.  0 equals unlimited time
   |
   */
    'timeout' => '0',


  /*
   |--------------------------------------------------------------------------
   |    TimeOut for Connection
   |--------------------------------------------------------------------------
   |
   | Maximum wait time for connection to proxy or target server.
   | In second. 0 equals unlimited time
   |
   */
    'timeoutConnect' => '7',



  /*
   |--------------------------------------------------------------------------
   |    Maximum number of results
   |--------------------------------------------------------------------------
   |
   | Maximum number of results for a query
   |
   */
    'maxItemPerRequest' => '500',


    /*
   |--------------------------------------------------------------------------
   |    Maximum attemps per search query
   |--------------------------------------------------------------------------
   |
   | The Maximum number of attempts to connect
   | through a proxy for a search query
   |
   */
    'maxAttemptPerSearch' => '10',




   /*
   |--------------------------------------------------------------------------
   |    Maximum number of requests
   |--------------------------------------------------------------------------
   |
   | The maximum number of requests per search
   |
   */
    'maxRequestPerSearch' => '100',

   /*
   |--------------------------------------------------------------------------
   |    Path to the Keys use by curl
   |--------------------------------------------------------------------------
   |
   | The relative path to file where the keys use by curl are stored.
   |
   */
    'pathHttpsKeyFile' => base_path("tools/cacert.pem"),


    /*
    |--------------------------------------------------------------------------
    |    The use of proxies
    |--------------------------------------------------------------------------
    |
    |Here you must specify whether you should use crawler with or without proxy
    | By default it is set to true
    |
    */
    'useProxy' => 'true',


    /*
    |--------------------------------------------------------------------------
    | Default Proxy Provenance
    |--------------------------------------------------------------------------
    |
    | Here you may specify where we should have to get the list of proxy
    | It can be via local (inside the crawler config )
    | Or via email
    | By default we use local
    |
    */
    'proxyProvenance' => 'local',


    /*
   |--------------------------------------------------------------------------
   | The Local Proxy List
   |--------------------------------------------------------------------------
   |
   | Here is the list of all the local proxies
   | that we use in this application.
   | Each proxy is use via the http or https protocol
   | Each proxy has an ip and a port. Both of them are necessary.
   |
   */
    'proxy' => [
        ['protocol' => 'socks5', 'ip' => '127.0.0.1', 'port' => '1050'],
    ],

    /**
     * Nombre maximal d'elements dans un email
     */

    'maxItemPerEmail' => '30',

    /**
     * Subject of the email sended by the proxy service
     */
    'proxyEmailSubject' => 'ProxyList for Today',

    /**
     * address's sender of the email sended by the proxy service
     */
    'proxyEmailSender' => 'noreply@pl.hidemyass.com',
];