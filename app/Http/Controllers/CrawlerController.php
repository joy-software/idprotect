<?php

namespace App\Http\Controllers;

use App\Search_Result;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;


use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleTor\Middleware;
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
    public $resultHeaderV = [];
    public $resultLinkV = [];
    public $resultLink_textV = [];
    public $resultVideo = [];
    public $resultBodyV = [];
    public $searchResults = [];
    public $count = 0;
    public $countV = 0;
    public $proxy = null;
    public $stringSearch = "";

    public function __construct()
    {
        $this->proxy = $this->get_proxies();
    }

    /**
     * @param Request $request
     * @param $requete
     * @return \Psr\Http\Message\StreamInterface
     */
    public function view(Request $request,$requete)
    {

        $stack = new HandlerStack();
        $stack->setHandler(new CurlHandler());
        $stack->push(Middleware::tor());
        $client = new GuzzleClient(['handler' => $stack]);

        //$url = 'https://check.torproject.org/';
       //$client = new GuzzleClient();
       //$client = new GuzzleClient($this->init());
       // if(empty($requete)) $requete = "ENSP Yaounde";
        $strSearch = $requete;
       // $url = $this->queryToUrl_min($strSearch,"CM");
       // $url = $this->queryToUrl($strSearch, 0, 20, "CM");
       // $url = "https://www.whatismyip.com";
        $url = 'https://spinproxies.com/';
        //  $url = "https://www.iplocation.net/find-ip-address";
        //echo $strSearch;
       // $url = "http://www.google.com/search?q=".$strSearch."&hl=en&start=0&sa=N";
        $jar = new CookieJar();

      //  $jar->setCookie(SetCookie::fromString($request->cookie('laravel-session')));

        // Go to the symfony.com website
        $crawler = $client->request('GET', $url,[
            'proxy'=>"socks5://127.0.0.1:9050",
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1)',
            ],
            'tor_new_identity'           => true,
            'tor_new_identity_sleep'     => 15,
            'tor_new_identity_timeout'   => 3,
            'tor_new_identity_exception' => true,
            'tor_control_password'       => 'password',//*/
            //'cookies' => $jar
        ]);
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
        //$proxys = $this->proxy;
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
        $config['proxy'] = ['http' => 'tcp://' . '1245857.04.4.1' . ': 1524' ];
/*
        if ($useProxy != 'false') {

            $status = 0;
            do
            {
                //$index = rand(0, count($proxys) - 1);
                $index = 0;
                $proxy = $proxys[$index];

                //$config['proxy'] = [$proxy['protocol'] => 'tcp://' . $proxy['ip'] . ':' . $proxy['port']];
                $config['proxy'] = ['socks5' => 'tcp://' . '127.0.0.1' . ': 1524' ];
               /* try {
                    $client = new GuzzleClient($config);
                    $crawler = $client->request('GET', 'http://www.google.com',[
                        'headers' => [
                            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                        ]]);
                    $status = $crawler->getStatusCode();
                    if($status == 200){
                        return $config;
                    }
                } catch (ConnectException $e) {
                    //Catch the guzzle connection errors over here.These errors are something
                    // like the connection failed or some other network error
                    //array_splice($proxys, $index, 1);
                }
               return $config;
            }
            while($status != 200);

        }
//*/
        return $config;

    }

    /**
     * The initialisation of our crawler
     * @param $url
     * @param $image
     * @return null|Crawler
     */
    public function launch_proxy($url,$image = false)
    {
        $proxys = $this->proxy;
        $timeout = Config::get('crawler.timeout');
        $timeoutConnect = Config::get('crawler.timeoutConnect');
        $stack = new HandlerStack();
        $stack->setHandler(new CurlHandler());
        $stack->push(Middleware::tor());

        $config = [
            'curl' => [
                CURLOPT_TIMEOUT => $timeout,
                CURLOPT_CONNECTTIMEOUT => $timeoutConnect
            ],
            'cookies' => true,
            'verify' => Config::get('crawler.pathHttpsKeyFile'),
            'handler' => $stack,
            'proxy'=>"socks5://127.0.0.1:9050",
            'tor_new_identity'           => true,
            'tor_new_identity_sleep'     => 15,
            'tor_new_identity_timeout'   => 3,
            'tor_new_identity_exception' => true,
            'tor_control_password'       => 'password',

        ];

        $useProxy = strtolower(Config::get('crawler.useProxy'));
        $crawler_ = null;

        if ($useProxy != 'false') {

            $status = true;
            do
            {
                //$index = rand(0, count($proxys) - 1);
                $index = 0;
                $proxy = $proxys[$index];

                //$config['proxy'] = [$proxy['protocol'] => 'tcp://' . $proxy['ip'] . ':' . $proxy['port']];

                try {

                    $client_ = new Client();
                    $client_->setClient(new GuzzleClient($config));
                    $client_->setHeader('User-Agent','Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
                   // $url  = 'http://freeproxylists.net/fr/?c=&pt=&pr=HTTPS&a%5B%5D=0&a%5B%5D=1&a%5B%5D=2&u=90';
                    if(!$image)
                    {
                        $crawler_ = $client_->request('GET', $url);
                    }
                    else
                    {
                        $crawler_[0] = $client_->request('GET', $url);
                        $crawler_[1] = $client_;
                    }

                } catch (ConnectException $e) {
                    //Catch the guzzle connection errors over here.These errors are something
                    // like the connection failed or some other network error
                    $status = false;
                }
            }
            while($status == false);

        }

        return $crawler_;

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
        //$url = 'http://freeproxylists.net/fr/?c=&pt=&pr=HTTPS&a%5B%5D=0&a%5B%5D=1&a%5B%5D=2&u=90';



    }

    /***
     * Getting the result over a search query
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
//*/

        $counts = 0;
        $nb = 40;
        $this->count = 0;
        $this->fetching($request,$nb);
        $this->recording($request,$counts,true);
//*/

       // $this->searchSocial($request);
        //$this->searchSocial($request,$country,2);
       // $this->searchSocial($request,$country,3);
        //$this->searchSocial($request,$country,4);
        //$this->searchDocument($request);
        //$this->searchDocument($request,$country);
        //$this->fetching_images($request);
        //$this->recording_images($request);
        //print_r($this->fetching_img($this->resultLink_text[0][0]));
        //$this->searchVideo($request);

        return response()->json($this->searchResults);//*/
    }

    /***
     * Getting the result over a search query
     * @param $request
     * @param array $country
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchII($request, $country = ['CM','FR','US'])
    {


        $counts = 0;
        $nb = 40;
        $this->count = 0;
        $search = '"'.$request.'"';
        $this->fetching($search,$nb,false,false,true);
        $this->recording($request,$counts,true);
//*/


        return response()->json($this->searchResults);//*/
    }

    /***
     * Getting the images related to the  search query
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchImages($request)
    {
       $this->fetching_images($request);
       $this->recording_images($request);



        return response()->json($this->searchResults);//*/
    }

    /**
     *  Getting result of the search query
     * @param $strSearch
     * @param $nb
     * @param array $country
     * @param bool $video
     */
    public function fetching($strSearch,$nb,$country = ['CM'],$video = false,$strict = false)
    {

        $client = new Client();
       // $client->setClient(new GuzzleClient($config));
        $client->setClient(new GuzzleClient(['cookies' => true]));
        $client->setHeader('User-Agent','Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
        //AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36 Edge/15.15063');
        $client->setHeader('Accept', '*/*');
        $client->setHeader('Accept-Encoding', 'gzip, deflate, br');
        $client->setHeader('Connection:', 'Keep-Alive');

     //   echo $strSearch ."<br/>";
        foreach ($country as $pays) {

            if($strict)
            {
                $url = $this->queryToUrl('"'.$strSearch.'"', 0, $nb, $pays,$video);
            }
            else
            {
                $url = $this->queryToUrl($strSearch, 0, $nb, $pays,$video);
            }
            // $url = $this->queryToUrl($strSearch, 0, $nb, $country[0],$video);

            //echo $strSearch;
            //$url = "http://www.google.com/search?q=".$strSearch."&hl=en&start=0&sa=N";
            // Go to the symfony.com website
            $crawler = $client->request('GET', $url);;
            //echo $crawler->html();
            $this->resultHeader[$this->count] = [];
            $this->resultLink[$this->count] = [];
            $this->resultLink_text[$this->count] = [];
            $this->resultBody[$this->count] = [];
           if($video)
           {
               $this->resultHeaderV[$this->countV] = [];
               $this->resultLinkV[$this->countV] = [];
               $this->resultLink_textV[$this->countV] = [];
               $this->resultVideo[$this->countV] = [];
               $this->resultBodyV[$this->countV] = [];
           }
            //on récupère les entêtes des résultats
            $crawler->filter('td div#center_col div.g')->each(function (Crawler $node, $i) {

                $header = $node->filter('h3 a');
                if ($header->count() > 0) {
                    $header = $header->html();
                    //print("<br/>".$header);
                    if (strpos($header, 'mages for') == false) {
                        //echo'<br/> '.$this->count.'<br/>';
                        //print_r($this->resultHeader);
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
            if($video)
            {
                $crawler->filter('td div#center_col div.g.videobox')->each(function (Crawler $node, $i) {
                    $video = $node->filter('td img')->attr('src');
                    array_push($this->resultVideo[$this->countV], $video);
                    $header = $node->filter('td h3 a');
                    if ($header->count() > 0) {
                        $link = $header->attr('href');
                        $link = substr($link,strpos($link,'='));
                        $link = substr($link,1,strpos($link,'&')-1);
                        array_push($this->resultLink_textV[$this->countV], $link);

                        $header = $header->html();
                        //print("<br/>".$header);
                        if (strpos($header, 'mages for') == false) {
                            array_push($this->resultHeaderV[$this->countV], $header);
                            $link = $node->filter('div cite')->html();

                            array_push($this->resultLinkV[$this->countV], $link);


                            if (strpos($link, 'books.google.com') == false) {
                                array_push($this->resultBodyV[$this->countV], $node->filter('div span.st')->html());
                            } else {
                                array_push($this->resultBodyV[$this->countV], $node->filter('div.s')->html());
                            }
                        }
                    }

                });

            }
            $this->count++;
            if($video)
            {
                $this->countV++;
            }
            $min =[5,8,9,10,12,7];
            sleep(rand(0,1)*count($min));
            //print count($searchResults);
        }
         //$url  = 'http://freeproxylists.net/fr/?c=&pt=&pr=HTTPS&a%5B%5D=0&a%5B%5D=1&a%5B%5D=2&u=90';
        //$crawler = $client->request('GET', $url);
       // echo $crawler->html();

    }

    /**
     * Getting result of the search query
     * @param $strSearch
     */
    public function fetching_images($strSearch)
    {
        //$client = new Client();
        //$client->setClient(new GuzzleClient($this->init()));
        //$client->setHeader('User-Agent','Mozilla/5.0 (Windows NT 10.0; Win64; x64)');

                //echo 'get';
            $url = $this->queryToUrl_min($strSearch);

            $crawler = $this->launch_proxy($url,true);

            //echo $crawler[0]->html();
            $this->count = 0;
            $this->resultHeader[$this->count] = [];
            $this->resultLink[$this->count] = [];
            $this->resultLink_text[$this->count] = [];
            $this->resultBody[$this->count] = [];
            //echo 'result';
            $this->stringSearch = $strSearch;
            //on récupère les entêtes des résultats
        $results = $crawler[0]->filter( 'div#ires table tr td')->each(function (Crawler $node, $i) {
               // echo 'ok';
                        return $node;
        });
               //print_r($results);
        foreach ($results as $result)
        {

           // $header = $result->filter('cite')->html();
           // $link = $result->filter('a')->attr('href');
            $preview = $result->text();

           // echo 'joy ';
            //echo $preview;
            //echo ' c\'est bon';
            if($this->contains_($preview,$this->stringSearch,true))
            {
                $header = $result->filter('cite')->html();
                $link = $result->filter('a img')->attr('src');
                array_push($this->resultHeader[$this->count], $header);
                array_push($this->resultLink[$this->count], $link);
                array_push($this->resultBody[$this->count], $preview);
                $link = $result->filter('a')->attr('href');
                $link = substr($link,strpos($link,'='));
                $link = substr($link,1,strpos($link,'&')-1);
                array_push($this->resultLink_text[$this->count], $link);
/*
                $crawler_ = $crawler[1]->request('GET', $link);
                $images = $crawler_->filter( 'img')->each(function (Crawler $node_, $i) {

                    return $node_;

                    // echo $test .' <br/>';
                });

                $height =  substr($preview,strpos($preview,'×'));
                $ext = substr($height,strpos($height,'-')+2);
                $ext = trim($ext);
                $height =  substr($height,strpos($height,'×'),strpos($height,'–'));
                $height =  substr($height,strpos($height,'×')+2,strpos($height,'–')-1);
                $height = trim($height);
                foreach ($images as $image)
                {
                    if(($this->contains_($image->attr('alt'),$strSearch,true))||
                        ($this->contains_($image->attr('src'),$ext,true,false)) && (strpos($image->attr('height'), $height) !== false) )
                    {

                        $link =  $image->attr('src');
                        echo $link ."<br/>";
                        array_push($this->resultLink_text[$this->count], $link);
                    }
                }
                //*/

               // echo 'header '.$header.'<br/>'. ' link: '.$link.'<br/>'.' preview'.$preview.'<br/> <br/>';
            }
//            sleep(1);
        }

    }


    /**
     * @param $search
     * @param $link
     * @param $preview
     * @return null
     */
    public function fetching_img($search,$link,$preview)
    {

        //$link = "https://helloworldpolytechnique.wordpress.com/tag/yoba-rostand/";
        //$search = "yoba rostand";
        //$crawler_ = $this->launch_proxy($link);

        $client_ = new Client();
        $client_->setHeader('User-Agent','Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
        $crawler_ = $client_->request('GET', $link);

       // $preview = "helloworldpolytechniqu...YOBA Rostand | HELLO WORLD !!! 220 × 126 – 12 Кб - jpg";


        $images = $crawler_->filter( 'img')->each(function (Crawler $node_, $i) {

           return $node_;

            // echo $test .' <br/>';
        });
        $results = null;
        $height =  substr($preview,strpos($preview,'×'));
        $ext = substr($height,strpos($height,'-')+2);
        $ext = trim($ext);

        $height =  substr($height,strpos($height,'×'),strpos($height,'–'));
        $height =  substr($height,strpos($height,'×')+2,strpos($height,'–')-1);
        $height = trim($height);

        foreach ($images as $image)
        {
            if(($this->contains_($image->attr('alt'),$search,true))||
                ($this->contains_($image->attr('src'),$ext,true,false)) && (strpos($image->attr('height'), $height) !== false) )
            {

                return  $image->attr('src');
            }
        }

        return $results;
    }

    /**
     * Putting the search result inside an array of object
     * @param $request
     * @param $count
     * @param $after
     * @param $category
     * @param $video
     * @return mixed
     */
    public function recording($request, $count,$after,$category = "all",$video = false)
    {
        if($video)
        {

            $counts = $count;
            $min = count($this->resultHeaderV[0]);
            foreach ($this->resultHeaderV as $header)
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

                    for ($pas = 0; $pas < count($this->resultHeaderV); $pas++)
                    {
                        $searchResult = new Search_Result([
                            'title' => $this->resultHeaderV[$pas][$count],
                            'link' => $this->resultLinkV[$pas][$count],
                            'links' => $this->resultLink_textV[$pas][$count],
                            'videoLink' => $this->resultVideo[$pas][$count],
                            'preview' => $this->resultBodyV[$pas][$count],
                            'category' => $category
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
                            'videoLink' => 'empty',
                            'preview' => $this->resultBody[$pas][$count],
                            'category' => $category
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
        }
        else{

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
                            'category' => $category
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
        }

        return $counts;
    }

    /**
     * Putting the search result inside an array of object
     * @param $request
     * @return mixed
     */
    public function recording_images($request)
    {
        $min = count($this->resultHeader[0]);

        if($min > 0)
        {
            // echo $min;
            //$compt = 0;
            for ($count = 0; $count < $min; $count++) {


                    $searchResult = new Search_Result([
                        'title' => $this->resultHeader[0][$count],
                        'link' => $this->resultLink[0][$count],
                        'links' => $this->resultLink_text[0][$count],
                        'preview' => $this->resultBody[0][$count],
                        'category' => 'images'
                    ]);

                    if(!$this->contains_searchResult($searchResult,$request))
                    {
                        array_push($this->searchResults, $searchResult);

                       // $compt++;
                    }

                }

        }
       // return $counts;
    }

    /**
     * Putting the search result inside an array of object
     * @param $request
     * @param $count
     * @param $after
     * @param $category
     * @return mixed
     */
    public function recording_social($request, $count,$after,$category)
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
                            'category' => $category
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
      $test = $this->contains_($searchResult,$request);
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
     * Check if a string is inside the request
     * @param $searchResult
     * @param $request
     * @param $string
     * @param $explode
     * @return bool
     */
    public function contains_($searchResult,$request, $string = false,$explode = true)
    {

        if($explode)
        {
            $terms = explode(" ",$request);
            $test = true;
            //print_r($terms);

            //check if the header/title of the result contains the keywords of the search query
            foreach ($terms as $term)
            {
                if($test)
                {
                    if(!$string)
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
                    else
                    {
                        if(strpos(strtolower($searchResult) ,strtolower($term)) !== false)
                        {
                            $test = true;
                        }
                        else
                        {
                            $test = false;
                        }
                    }
                }
            }
            if(!$string)
            {
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
            }
        }
        else{
            if(strpos(strtolower($searchResult) ,strtolower($request)) !== false)
            {
                $test = true;
            }
            else
            {
                $test = false;
            }
        }


        return $test;

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
     * @param int $index
     * @param array $country
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchSocial($request,$index = 1,$country = ['CM'])
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
            $this->fetching($strSearch." site:".$social,$nb,$country);
            //$counts = $this->recording($request,$counts,false);
            sleep(1);
        }

      /*  $this->count = 0;
        $strSearch = $request;

        foreach ($socials as $social) {

            //echo $strSearch;
            $this->fetching($strSearch." ".$social,$country,$nb);

        }//*/
         $counts = $this->recording_social($request,$counts,false,"social");
       // echo $counts;

        return response()->json($this->searchResults);
    }

    /**
     * search for some traces in files
     * @param $request
     * @param int $index
     * @param array $country
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchDocument($request,$index = 1,$country = ['CM'])
    {
        $documents = [];
        switch ($index)
        {
            case 1: $documents = ['pdf','doc', 'docx','tex'];
                break;
            case 2: $documents = ['ppt','pptx', 'odp','xml'];
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
            $this->fetching($strSearch." filetype:".$document,$nb,$country);
            //$counts = $this->recording($request,$counts,false);
        }


        $this->recording_social($request,$counts,false,"document");
        // echo $counts;

        //
        return response()->json($this->searchResults);
    }



    /**
     * search for some traces in files
     * @param $request
     * @param array $country
     */
    public function searchVideo($request,$country = ['CM','US','FR'])
    {


        $counts = 0;
        //$strSearch = '"'.$request.'"';
        $strSearch = $request;
        $nb = 20;
        $this->count = 0;
        $this->countV = 0;


       // foreach ($country as $pays) {
            //echo $strSearch;
           // $this->fetching($strSearch,$pays,$nb,true);
            $this->fetching($strSearch,$nb,$country,true);
            //$counts = $this->recording($request,$counts,false);
     //   }


        $this->recording($request,$counts,false,"video",true);
        // echo $counts;

        return response()->json($this->searchResults);
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

    /**
 * Tansform the given parameters into a suitable query
 * @param $query
 * @param null $start
 * @param int $perPage
 * @param string $country
 * @return string
 */
    function queryToUrl($query, $start=null, $perPage=100, $country="US",$video = false) {

        if (!$video)
        {
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
        else{
            $result = "http://www.google.com/search?" . http_build_query(array(
                    // Query
                    //"q"     => urlencode($query),
                    "q"     => $query,
                    // Country (geolocation presumably)
                    "tbm" => "vid",
                    "gl"    => $country,
                    //"siteSearch" => "twitter",
                    // Number of result to a page
                    "num"   => $perPage
                ), true);
            return $result;
        }
    }


    /**
     * Tansform the given parameters into a suitable query
     * @param $query
     * @param string $country
     * @return string
     */
    function queryToUrl_min($query, $country="US") {
            return "http://www.google.com/search?" . http_build_query(array(
                    // Query
                    //"q"     => urlencode($query),
                    "q"     => $query,
                    "tbm" => "isch",
                    // Country (geolocation presumably)
                    "gl"    => $country,
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
