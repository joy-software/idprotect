<?php

namespace App\Http\Controllers;

use App\Search_Result;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;
use Symfony\Component\DomCrawler\Crawler;

class CrawlerController extends Controller
{

    public $resultHeader = [];
    public $resultLink = [];
    public $resultLink_text = [];
    public $resultBody = [];
    public $searchResults = [];
    public $count = 0;
    public $proxy = null;

    public function __construct()
    {
        $this->proxy = $this->get_proxies();
    }

    /**
     *
     */
    public function view($requete)
    {


       $client = new GuzzleClient($this->init());
        if(empty($requete)) $requete = "ENSP Yaounde";
        $strSearch = $requete;
        //$url = $this->queryToUrl($strSearch, 0, 20, "CM");
        $url = "https://www.whatismyip.com";
      //  $url = "https://www.iplocation.net/find-ip-address";
        //echo $strSearch;
       // $url = "http://www.google.com/search?q=".$strSearch."&hl=en&start=0&sa=N";
        // Go to the symfony.com website
        $crawler = $client->request('GET', $url,[
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
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

        $client = new GuzzleClient($this->init());
        $strSearch = "ENSP Yaounde";
        //echo $strSearch;
        $url = "http://www.google.com/search?q=".$strSearch."&hl=en&start=0&sa=N";
        // Go to the symfony.com website
        $crawler = $client->request('GET', $url);
        return $crawler->getBody();
    }

    /**
     * The initialisation of our crawler
     * @return array
     */
    public function init()
    {
        $proxys = $this->proxy;
        $timeout = Config::get('crawler.timeout');
        $timeoutConnect = Config::get('crawler.timeoutConnect');

        $config = [
            'curl' => [
                CURLOPT_TIMEOUT => $timeout,
                CURLOPT_CONNECTTIMEOUT => $timeoutConnect
            ],

            'verify' => Config::get('crawler.pathHttpsKeyFile')
        ];

        $useProxy = strtolower(Config::get('crawler.useProxy'));

        if ($useProxy != 'false') {

            $index = rand(0, count($proxys) - 1);
            $proxy = $proxys[$index];

            $config['proxy'] = [$proxy['protocol'] => 'tcp://' . $proxy['ip'] . ':' . $proxy['port']];
        }

        return $config;
    }


    /**
     * Get proxy files from email account or local proxy configurations
     * @return array|mixed
     */
    public function get_proxies()
    {
        $proxyProvenance = Config::get('crawler.proxyProvenance');

        if ($proxyProvenance != 'local') {

            $date = date('Y-m-d', time());

            if (! Storage::disk('crawler')->has('proxy/' . $date)) {

                $client = new ImapClient(Config::get('imap.accounts.proxy'));
                $client->connect();
                $folder = $client->getFolders();
                $folder = $folder[0];
                $message = $client->getMessages($folder, 'FROM "' . Config::get('crawler.proxyEmailSender') . '" SUBJECT "' . Config::get('crawler.proxyEmailSubject') . '" ON ' . $date);

                if (empty($message)) {

                    if ($proxy = json_decode(env('PROXY_CRAWLER'), true)) {

                        return $proxy;

                    } else {

                        throw new UnreachableServerException('Proxy files are unvailable');
                    }
                }

                Storage::disk('crawler')->makeDirectory('proxy/' . $date);

                $attachments = array();
                $proxyZip = array();
                $i = 0;

                foreach ($message as $msg) {

                    $attachments[$i] = $msg->attachments;
                    $proxyZip[$i] = $attachments[$i][0];

                    Storage::disk('crawler')->makeDirectory('proxy/' . $date .  '/proxy_' . $i);
                    Storage::disk('crawler')->put('proxy/' . $date . '/proxy_' . $i . '.zip', $proxyZip[$i]->content);

                    $zip = new \ZipArchive();


                    $res = $zip->open(storage_path('crawler') . '/proxy/' . $date . '/proxy_' . $i . '.zip');

                    if  ($res == true) {

                        $zip->extractTo(storage_path('crawler') . '/proxy/' . $date . '/proxy_' . $i);
                        $zip->close();
                    }

                    $i++;
                }

                return $this->storeProxyInEnv();

            } else {

                if ($proxy = json_decode(env('PROXY_CRAWLER'), true)) {

                    return $proxy;
                }

                return $this->storeProxyInEnv();
            }

        } else {

            return Config::get('crawler.proxy');
        }

    }

    /***
     * Getting the result over a search request
     * @param $request
     * @param array $country
     * @return \Illuminate\Http\JsonResponse
     */
    public function search($request, $country = ['CM','FR','US'])
    {
        /*$command = "allintitle%3A+";
        $command1 = "insubject%3A+";
        if(empty($request)) $request = "ENSP Yaounde";

         $nb = 40;
        $counts = 0;
        $strSearch = '"'.$request.'"';
        //echo $strSearch;
        $this->fetching($strSearch,$country,$nb);
        $counts = $this->recording($request,$counts,false);


        $this->count = 0;
        $strSearch = $request;
        $this->fetching($strSearch,$country,$nb);
        $this->recording($request,$counts,true);
//*/

        //$this->searchSocial($request,$country);
        //$this->searchSocial($request,$country,2);
       // $this->searchSocial($request,$country,3);
        //$this->searchSocial($request,$country,4);
        $this->searchDocument($request,$country);


        return response()->json($this->searchResults);//*/
    }

    /**
     * Getting result of the search query
     * @param $strSearch
     * @param $country
     * @param $nb
     */
    public function fetching($strSearch,$country,$nb)
    {
        $client = new Client();
         $client->setClient(new GuzzleClient($this->init()));
        $client->setHeader('User-Agent','Mozilla/5.0 (Windows NT 10.0; Win64; x64)');


        foreach ($country as $pays) {
            $url = $this->queryToUrl($strSearch, 0, $nb, $pays);
            //echo $strSearch;
            //$url = "http://www.google.com/search?q=".$strSearch."&hl=en&start=0&sa=N";
            // Go to the symfony.com website
            $crawler = $client->request('GET', $url);

            $this->resultHeader[$this->count] = [];
            $this->resultLink[$this->count] = [];
            $this->resultLink_text[$this->count] = [];
            $this->resultBody[$this->count] = [];
            //on récupère les entêtes des résultats
            $crawler->filter('td div#center_col div.g')->each(function (Crawler $node, $i) {

                $header = $node->filter('h3 a');
                if ($header->count() > 0) {
                    $header = $header->html();
                    //print("<br/>".$header);
                    if (strpos($header, 'mages for') == false) {
                        array_push($this->resultHeader[$this->count], $header);
                        $link = $node->filter('div cite')->html();

                        array_push($this->resultLink[$this->count], $link);
                        $link = $node->filter('div cite')->text();
                        array_push($this->resultLink_text[$this->count], $link);

                        if (strpos($link, 'books.google.com') == false) {
                            array_push($this->resultBody[$this->count], $node->filter('div span.st')->html());
                        } else {
                            array_push($this->resultBody[$this->count], $node->filter('div.s')->html());
                        }
                    }
                }
            });
            $this->count++;

            //print count($searchResults);
        }
    }

    /**
     * Putting the search result inside an array of object
     * @param $request
     * @param $count
     * @return mixed
     */
    public function recording($request, $count,$after)
    {
        $counts = $count;
        $min = count($this->resultHeader[0]);
        foreach ($this->resultHeader as $header)
        {
            if(count($header) < $min)
            {
                $min = count($header);
            }
        }

        if($min > 0)
        {
            // echo $min;
            $compt = 0;
            for ($count = 0; $count < $min; $count++) {

                for ($pas = 0; $pas < count($this->resultHeader); $pas++)
                {
                    $searchResult = new Search_Result([
                        'title' => $this->resultHeader[$pas][$count],
                        'link' => $this->resultLink[$pas][$count],
                        'links' => $this->resultLink_text[$pas][$count],
                        'preview' => $this->resultBody[$pas][$count],
                        'category' => 'all'
                    ]);

                    if(!$this->contains_searchResult($searchResult,$request))
                    {
                        if($after)
                        {
                            array_splice( $this->searchResults, 2*$compt, 0, array($searchResult) );
                        }
                        else
                        {
                            array_push($this->searchResults, $searchResult);
                        }
                        $compt++;
                        $counts++;
                    }

                }
            }
        }
        return $counts;
    }

    /**
     * Putting the search result inside an array of object
     * @param $request
     * @param $count
     * @param $after
     * @param $socials
     * @return mixed
     */
    public function recording_social($request, $count,$after,$socials)
    {
        $counts = $count;

        do
        {
            $min = count($this->resultHeader[0]);
            $pos = [];
            $nbr = 0;

            foreach ($this->resultHeader as $header) {
                if (count($header) < $min) {
                    $min = count($header);
                }
            }
            foreach ($this->resultHeader as $header) {
                if (count($header) == $min) {
                    array_push($pos,$nbr);
                }
                $nbr++;
            }



            if ($min > 0) {
                 //echo $min . "     ".count($this->resultHeader);
                $compt = 0;
                for ($count = 0; $count < $min; $count++) {

                    for ($pas = 0; $pas < count($this->resultHeader); $pas++) {
                        $searchResult = new Search_Result([
                            'title' => $this->resultHeader[$pas][$count],
                            'link' => $this->resultLink[$pas][$count],
                            'links' => $this->resultLink_text[$pas][$count],
                            'preview' => $this->resultBody[$pas][$count],
                            'category' => 'all'
                        ]);

                        if (!$this->contains_searchResult($searchResult, $request)) {
                            if ($after) {
                                array_splice($this->searchResults, 2 * $compt, 0, array($searchResult));
                            } else {
                                array_push($this->searchResults, $searchResult);
                            }
                            $compt++;
                            $counts++;
                        }

                    }
                }
            }
            //unset($this->resultHeader[$pos]);
            foreach ($pos as $po)
            {
                array_splice($this->resultHeader, $po, 1);
                array_splice($this->resultLink, $po, 1);
                array_splice($this->resultBody, $po, 1);
                array_splice($this->resultLink_text, $po, 1);
            }


        }
        while(count($this->resultHeader)>0);
        return $counts;
    }

    /**
     * To check if a result is already inside the result array
     * if not we can do the push
     * @param $searchResult
     * @param $request
     * @return bool
     */
    public function contains_searchResult($searchResult, $request)
    {
        $terms = explode(" ",$request);
        $test = true;
        //print_r($terms);

        //check if the header/title of the result contains the keywords of the search query
        foreach ($terms as $term)
            {
                if($test)
                {

                    if(strpos(strtolower($searchResult->title) ,strtolower($term)) !== false)
                    {
                        $test = true;
                    }
                    else
                    {
                        $test = false;
                    }
                }
            }
            if(!$test)
            {
                //check if the link of the result contains the keywords of the search query
                $test = true;
                foreach ($terms as $term)
                {
                    if($test)
                    {
                        if(strpos(strtolower($searchResult->link) ,strtolower($term)) !== false)
                        {
                            $test = true;
                        }
                        else
                        {
                            $test = false;
                        }
                    }
                }
                if(!$test)
                {
                    //check if the body of the result contains the keywords of the search query
                    $test = true;
                    foreach ($terms as $term)
                    {
                        if($test)
                        {
                           // echo strtolower($searchResult->preview);
                            if(strpos(strtolower($searchResult->preview) ,strtolower($term)) !== false)
                            {
                                $test = true;
                               // echo "<br/>";
                            }
                            else
                            {
                                $test = false;
                            }
                        }
                    }
                }
            }
            if(!$test)
            {
                return true;
            }
            else
            {
                //echo "else <br/>";
                //check the result is already record
                foreach ($this->searchResults as $result)
                {
                   // echo "<br/> a";
                    if(strpos(strtolower($result->links) ,strtolower($searchResult->links)) !== false)
                    {
                       // echo "return 1";
                        return true;
                    }
                    //echo "yes";

                }
            }
       // echo "rien";

        return false;
    }

    /**
     * To check if a result is already inside the result array
     * if not we can do the push
     * @param $searchResult
     * @param $request
     * @param $socials
     * @return bool
     */
    public function contains_searchResult_social($searchResult, $request,$socials)
    {
        $terms = explode(" ",$request);
        $test = false;
        //print_r($terms);

        //check if the header/title of the result contains the keywords of the search query

        foreach ($socials as $social) {
            if (strpos(strtolower($searchResult->links), strtolower($social)) !== false) {
                $test = true;
                break;
            }
        }//*/
        if($test)
        {
            foreach ($terms as $term)
            {
                if($test)
                {
                    if(strpos(strtolower($searchResult->title) ,strtolower($term)) !== false)
                    {
                        $test = true;
                    }
                    else
                    {
                        $test = false;
                    }
                }
            }
            if(!$test)
            {
                //check if the link of the result contains the keywords of the search query
                $test = true;
                foreach ($terms as $term)
                {
                    if($test)
                    {

                        if(strpos(strtolower($searchResult->link) ,strtolower($term)) !== false)
                        {
                            $test = true;
                        }
                        else
                        {
                            $test = false;
                        }
                    }
                }
                if(!$test)
                {
                    //check if the body of the result contains the keywords of the search query
                    $test = true;
                    foreach ($terms as $term)
                    {
                        if($test)
                        {
                            // echo strtolower($searchResult->preview);
                            if(strpos(strtolower($searchResult->preview) ,strtolower($term)) !== false)
                            {

                                // echo "<br/>";
                            }
                            else
                            {
                                $test = false;
                            }
                        }
                    }
                }
            }
        }
        if(!$test)
        {
            return true;
        }
        else
        {
            //echo "else <br/>";
            //check the result is already record
            foreach ($this->searchResults as $result)
            {
                // echo "<br/> a";
                if(strpos(strtolower($result->links) ,strtolower($searchResult->links)) !== false)
                {
                    return true;
                }
                //echo "yes";

            }
        }
        // echo "rien";

        return false;
    }

    /**
     * search for some traces on social media
     * @param $request
     * @param array $country
     * @param int $index
     */
    public function searchSocial($request,$country = ['CM'],$index = 1)
    {
        $socials = [];
        switch ($index)
        {
            case 1: $socials = ['Facebook.com','Twitter.com','LinkedIn.com','plus.google.com','YouTube.com'];
                    break;
            case 2: $socials = ['Instagram.com','Pinterest.com','Meetup.com','badoo.com','meetic.fr'];
                    break;
            case 3: $socials = ['Flickr.com','VK.com','Reddit.com','Ask.fm','Tumblr.com','Vine.co'];
                    break;
            case 4: $socials = ['viadeo.com','skyrock.com','myspace.com','tagged.com'];
                    break;
        }


        $counts = 0;
        $strSearch = '"'.$request.'"';
        $nb = 5;
        $this->count = 0;


        foreach ($socials as $social) {
            //echo $strSearch;
            $this->fetching($strSearch." site:".$social,$country,$nb);
            //$counts = $this->recording($request,$counts,false);
        }

      /*  $this->count = 0;
        $strSearch = $request;

        foreach ($socials as $social) {

            //echo $strSearch;
            $this->fetching($strSearch." ".$social,$country,$nb);

        }//*/
         $counts = $this->recording_social($request,$counts,false,$socials);
       // echo $counts;

        //
    }

    /**
     * search for some traces in files
     * @param $request
     * @param array $country
     * @param int $index
     */
    public function searchDocument($request,$country = ['CM,US,FR'],$index = 1)
    {
        $documents = [];
        switch ($index)
        {
            case 1: $documents = ['pdf','doc', 'docx','xml'];
                break;
            case 2: $documents = ['ppt','pptx', 'odp','tex'];
                break;
            case 3: $documents = ['gdoc','docm','log','odt','txt'];
                break;
            case 4: $documents = ['mp3', 'mp4', 'mpeg', 'flv', 'avi','3gp','dat'];
                break;
            case 5: $documents = ['aac','arc','zip','rar', 'jar', 'tar','tgz','iso'];
                break;
        }


        $counts = 0;
        //$strSearch = '"'.$request.'"';
        $strSearch = $request;
        $nb = 20;
        $this->count = 0;


        foreach ($documents as $document) {
            //echo $strSearch;
            $this->fetching($strSearch." filetype:".$document,$country,$nb);
            //$counts = $this->recording($request,$counts,false);
        }

        /*  $this->count = 0;
          $strSearch = $request;

          foreach ($socials as $social) {

              //echo $strSearch;
              $this->fetching($strSearch." ".$social,$country,$nb);

          }//*/
        $counts = $this->recording_social($request,$counts,false,$documents);
        // echo $counts;

        //
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
            //"q"     => urlencode($query),
            "q"     => $query,
            // Country (geolocation presumably)
            "gl"    => $country,
            //"siteSearch" => "twitter",
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
