<?php

namespace App\Http\Controllers;

use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;


use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class CrawlerController extends Controller
{
    /**
     *
     */
    public function view($requete)
    {

        $client = new GuzzleClient();
        if(empty($requete)) $requete = "\"bayoi+michel\"";
        $strSearch = $requete;
        //echo $strSearch;
        $url = "http://www.google.com/search?q=".$strSearch."&hl=en&start=0&sa=N";
        // Go to the symfony.com website
        $crawler = $client->request('GET', $url);
        return $crawler->getBody();
    }

    /**
     *
     */
    public function views()
    {

        $client = new GuzzleClient();
        $strSearch = "\"bayoi+michel\"";
        //echo $strSearch;
        $url = "http://www.google.com/search?q=".$strSearch."&hl=en&start=0&sa=N";
        // Go to the symfony.com website
        $crawler = $client->request('GET', $url);
        return $crawler->getBody();
    }

    public function search($requete)
    {
        $client = new Client();
        $command = "allintitle%3A+";
        $command1 = "insubject%3A+";
        if(empty($requete)) $requete = "\"bayoi+michel\"";
        $strSearch = $requete;
        //echo $strSearch;
        $url = "http://www.google.com/search?q=".$strSearch."&hl=en&start=0&sa=N";
        // Go to the symfony.com website
        $crawler = $client->request('GET', $url);

         $nodeValues = $crawler->filter('ol > div')->each(function (Crawler $node, $i) {
             return $node->text();
         });
         print_r($nodeValues);//*/

    }

    public function searchs()
    {
        $client = new Client();
        $command = "allintitle%3A+";
        $command1 = "insubject%3A+";
        $strSearch = "\"bayoi+michel\"";
        //echo $strSearch;
        $url = "http://www.google.com/search?q=".$strSearch."&hl=en&start=0&sa=N";
        // Go to the symfony.com website
        $crawler = $client->request('GET', $url);

        $nodeValues = $crawler->filter('ol > div')->each(function (Crawler $node, $i) {
            return $node->text();
        });
        print_r($nodeValues);//*/

    }
}
