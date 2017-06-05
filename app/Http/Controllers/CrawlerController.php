<?php

namespace App\Http\Controllers;

use App\Search_Result;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\DomCrawler\Crawler;

class CrawlerController extends Controller
{

    public $resultHeader = [];
    public $resultLink = [];
    public $resultBody = [];

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
        $crawler = $client->request('GET', $url,[
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) ',
            ]]);
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
        $url = $this->queryToUrlBing($strSearch, 0, 30, "");
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
       // $client->setClient(new GuzzleClient());
        $client->setHeader('User-Agent','Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
        $command = "allintitle%3A+";
        $command1 = "insubject%3A+";
        if(empty($requete)) $requete = "ENSP Yaounde";
        $strSearch = $requete;
        $nb = 20;
        $url = $this->queryToUrl($strSearch, 0, $nb, "CM");
        //echo $strSearch;
        //$url = "http://www.google.com/search?q=".$strSearch."&hl=en&start=0&sa=N";
        // Go to the symfony.com website
        $crawler = $client->request('GET', $url);



        //on récupère les entêtes des résultats
        $crawler->filter('td div#center_col div.g')->each(function (Crawler $node, $i) {
            $header = $node->filter('h3 a')->html();

            if(strpos($header,'mages for') == false)
            {
                array_push($this->resultHeader,$header);
                $link = $node->filter('div cite')->html();

                array_push($this->resultLink,$link);

                if(strpos($link,'books.google.com') == false)
                {
                    array_push($this->resultBody,$node->filter('div span.st')->html());
                }
                else{
                    array_push($this->resultBody,$node->filter('div.s')->html());
                }
            }


           //print_r($this->resultHeader);
        });
        /* $resultHeaders = $crawler->filter('td div#center_col h3 a')->each(function (Crawler $node, $i) {
             return $node->fil;
         });
        $resultHeader = array_flatten($resultHeaders);


        $resultLinks = $crawler->filter('td div#center_col div cite')->each(function (Crawler $node, $i) {
            return $node->html();
        });
        $resultLink = array_flatten($resultLinks);

        $resultBodys = $crawler->filter('td div#center_col div span.st')->each(function (Crawler $node, $i) {
            return $node->html();
        });
        $resultBody = array_flatten($resultBodys);//*/


        $count = 0;

        $searchResults = [];
        foreach ($this->resultHeader as $data)
        {
            //print ($count."  ".$data."<br> <br> ");
            //print ($count."  ".$except."<br> <br> ");

             $searchResult = new Search_Result([
                   'title' => $this->resultHeader[$count],
                    'link' => $this->resultLink[$count],
                    'preview' => $this->resultBody[$count]
                ]);

                array_push($searchResults,$searchResult);

            $count++;
        }
        //print count($searchResults);

         //print_r($nodeValues);//*/
        return response()->json($searchResults);

    }

    public function searchBing($requete)
    {
        $client = new Client();
        /*$command = "allintitle%3A+";
        $command1 = "insubject%3A+";
        if(empty($requete)) $requete = "ENSP Yaounde";
        $strSearch = $requete;
        $url = $this->queryToUrlBing($strSearch, 0, 20, "fr-FR");
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
        $client->setHeader('User-Agent','Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
        $command = "allintitle%3A+";
        $command1 = "insubject%3A+";
        if(empty($requete)) $requete = "ENSP Yaounde";
        $strSearch = $requete;
        $nb = 20;

        //Compose the url for the request
        $url = $this->queryToUrlBing($strSearch, 0, $nb, "fr-FR");

        // Launch the request trough the crawler
        $crawler = $client->request('GET', $url);

        //We get the headings of the search Results
        $resultHeaders = $crawler->filter('ol#b_results li.b_algo h2')->each(function (Crawler $node, $i) {
            return $node->html();
        });
        $resultHeader = array_flatten($resultHeaders);

        //Getting the result links
        $resultLinks = $crawler->filter('ol#b_results li.b_algo div cite')->each(function (Crawler $node, $i) {
            return $node->html();
        });
        $resultLink = array_flatten($resultLinks);

        $resultBodys = $crawler->filter('ol#b_results li.b_algo div p')->each(function (Crawler $node, $i) {
            return $node->html();
        });
        $resultBody = array_flatten($resultBodys);


        $count = 0;
        $except = $nb + 1 ;
        $searchResults = [];
        foreach ($resultHeader as $data)
        {
            if(strpos($data,'mages for') == false)
            {
               // print ($count."  ".$data."<br> <br> ");
                //print ($count."  ".$except."<br> <br> ");
                if($count < $except)
                {
                    $searchResult = new Search_Result([
                        'title' => $resultHeader[$count],
                        'link' => $resultLink[$count],
                        'preview' => $resultBody[$count]
                    ]);

                    array_push($searchResults,$searchResult);
                }
                else{
                    $searchResult = new Search_Result([
                        'title' => $resultHeader[$count],
                        'link' => $resultLink[$count - 1],
                        'preview' => $resultBody[$count - 1],
                        'source' => 'alto'
                    ]);
                    array_push($searchResults,$searchResult);
                }
            }
            else
            {
                $except = $count;
            }
            $count++;
        }
        //print count($searchResults);

        //print_r($nodeValues);//*/
        return response()->json($searchResults);

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

    function queryToUrlBing($query, $start=null, $perPage=100, $country="") {
        return "http://www.bing.com/search?" . http_build_query(array(
            // Query
            "q"     => $query,
            // Country (geolocation presumably)
            "mkt"    => $country,
            // Start offset
            "first" => $start,
            // Number of result to a page less than 50
            "count"   => $perPage
        ), true);
    }


}
