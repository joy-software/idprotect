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
        if(empty($requete)) $requete = "ENSP Yaounde";
        $strSearch = $requete;
        $url = $this->queryToUrl($strSearch, 0, 20, "FR");
        //echo $strSearch;
       // $url = "http://www.google.com/search?q=".$strSearch."&hl=en&start=0&sa=N";
        // Go to the symfony.com website
        $crawler = $client->request('GET', $url);
        return $crawler->getBody();
    }

    /**
     *
     */
    public function viewBing($requete)
    {

        $client = new GuzzleClient();
        if(empty($requete)) $requete = "ENSP Yaounde";
        $strSearch = $requete;
        $url = $this->queryToUrlBing($strSearch, 0, 20, "FR");
        //echo $strSearch;
        // $url = "http://www.google.com/search?q=".$strSearch."&hl=en&start=0&sa=N";
        // Go to the symfony.com website
        $crawler = $client->request('GET', $url);
        return $crawler->getBody();
    }

    public function viewDuck($requete)
    {

        $client = new GuzzleClient();
        if(empty($requete)) $requete = "ENSP Yaounde";
        $strSearch = $requete;
        $url = $this->queryToUrlDuckgo($strSearch, 0, 20, "FR");
        //echo $strSearch;
        // $url = "http://www.google.com/search?q=".$strSearch."&hl=en&start=0&sa=N";
        // Go to the symfony.com website
        $crawler = $client->request('GET', $url);
        return $crawler->getBody();
    }

    public function nbchange($nb)
    {

        $client = new GuzzleClient();
        $strSearch = "ENSP Yaounde";
        $url = $this->queryToUrl($strSearch, 0, $nb, "FR");
        //echo $strSearch;
        // $url = "http://www.google.com/search?q=".$strSearch."&hl=en&start=0&sa=N";
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
        $strSearch = "ENSP Yaounde";
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
        if(empty($requete)) $requete = "ENSP Yaounde";
        $strSearch = $requete;
        $url = $this->queryToUrl($strSearch, 0, 20, "FR");
        //echo $strSearch;
        //$url = "http://www.google.com/search?q=".$strSearch."&hl=en&start=0&sa=N";
        // Go to the symfony.com website
        $crawler = $client->request('GET', $url);

         $nodeValues = $crawler->filter('ol > div')->each(function (Crawler $node, $i) {
             return $node->text();
         });
        $array = array_flatten($nodeValues);
        foreach ($array as $data)
        {
            print ($data."<br> <br> ");
        }
         //print_r($nodeValues);//*/

    }

    public function searchBing($requete)
    {
        $client = new Client();
        $command = "allintitle%3A+";
        $command1 = "insubject%3A+";
        if(empty($requete)) $requete = "ENSP Yaounde";
        $strSearch = $requete;
        $url = $this->queryToUrlBing($strSearch, 0, 20, "FR");
        //echo $strSearch;
        //$url = "http://www.google.com/search?q=".$strSearch."&hl=en&start=0&sa=N";
        // Go to the symfony.com website
        $crawler = $client->request('GET', $url);

        $nodeValues = $crawler->filter('ol > div')->each(function (Crawler $node, $i) {
            return $node->text();
        });
        $array = array_flatten($nodeValues);
        foreach ($array as $data)
        {
            print ($data."<br> <br> ");
        }
        //print_r($nodeValues);//*/

    }

    public function searchDuck($requete)
    {
        $client = new Client();
        $command = "allintitle%3A+";
        $command1 = "insubject%3A+";
        if(empty($requete)) $requete = "ENSP Yaounde";
        $strSearch = $requete;
        $url = $this->queryToUrlDuckgo($strSearch, 0, 20, "FR");
        //echo $strSearch;
        //$url = "http://www.google.com/search?q=".$strSearch."&hl=en&start=0&sa=N";
        // Go to the symfony.com website
        $crawler = $client->request('GET', $url);

        $nodeValues = $crawler->filter('ol > div')->each(function (Crawler $node, $i) {
            return $node->text();
        });
        $array = array_flatten($nodeValues);
        foreach ($array as $data)
        {
            print ($data."<br> <br> ");
        }
        //print_r($nodeValues);//*/

    }


    public function searchs()
    {
        $client = new Client();
        $command = "allintitle%3A+";
        $command1 = "insubject%3A+";
        $strSearch = "ENSP Yaounde";
        //echo $strSearch;
        $url = "http://www.google.com/search?q=".$strSearch."&hl=en&start=0&sa=N";
        // Go to the symfony.com website
        $crawler = $client->request('GET', $url);

        $nodeValues = $crawler->filter('ol > div')->each(function (Crawler $node, $i) {
            return $node->text();
        });
        print_r($nodeValues);//*/

    }

    function queryToUrl($query, $start=null, $perPage=100, $country="US") {
        return "http://www.google.com/search?" . http_build_query(array(
            // Query
            "q"     => urlencode($query),
            // Country (geolocation presumably)
            "gl"    => $country,
            // Start offset
            "start" => $start,
            // Number of result to a page
            "num"   => $perPage
        ), true);
    }

    function queryToUrlBing($query, $start=null, $perPage=100, $country="US") {
        return "http://www.bing.com/search?" . http_build_query(array(
            // Query
            "q"     => urlencode($query),
            // Country (geolocation presumably)
            "gl"    => $country,
            // Start offset
            "start" => $start,
            // Number of result to a page
            "num"   => $perPage
        ), true);
    }

    function queryToUrlDuckgo($query) {
        return "http://duckduckgo.com/?q=joy+ndja";
    }

}
