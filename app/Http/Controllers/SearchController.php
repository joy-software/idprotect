<?php

namespace App\Http\Controllers;

use App\Search;
use App\Search_Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{

    protected  $crawlInstance;

    public function __construct()
    {
        $this->crawlInstance = new CrawlerController();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'keywords' => 'required'
        ]);

       $keywords =   strtolower($request->keywords);

        //We check if the result of this search is already in our database
        $idem = Search::whereKeywords($keywords)->get()->count();


        if($idem == 0)
        {
            $search = new Search([
                'keywords' => strtolower($keywords)
            ]);
            $user = Auth::user();
            $search->user()->associate($user);
            $search->save();
        }
        $this->crawlInstance = new CrawlerController();


        return $this->crawlInstance->search($keywords);
    }


    public function searchII($request)
    {

        //We check if the result of this search is already in our database
       /* $idem = Search::whereKeywords(strtolower($request))->get()->count();


        if($idem == 0)
        {
            $search = new Search([
                'keywords' => strtolower($request)
            ]);
            $user = Auth::user();
            $search->user()->associate($user);
            $search->save();
        }//*/

        return $this->crawlInstance->searchII($request);
    }

    public function searchSocial($request,$index)
    {


        $this->crawlInstance->searchSocial($request,$index);

    }

    public function searchDocument($request,$index)
    {


        $this->crawlInstance->searchDocument($request);
    }

    public function searchImages($request)
    {
        $this->crawlInstance->searchImages($request);
    }

    public function searchVideo($request)
    {
        $this->crawlInstance->searchVideo($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Search  $search
     * @return \Illuminate\Http\Response
     */
    public function show(Search $search)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Search  $search
     * @return \Illuminate\Http\Response
     */
    public function edit(Search $search)
    {
        //
    }


    /**
     * Validate a search Result Object
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function valid(Request $request)
    {
        $this->validate($request,[
            'idResult' => 'required'
        ]);

        $result = Search_Result::findOrFail($request->idResult);


        if($result)
        {
            $result->statut = 'valid';
            $result->save();
        }

        return response()->json($result);

    }

    /**
     * Reject a search Result Object
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reject(Request $request)
    {
        $this->validate($request,[
            'idResult' => 'required'
        ]);

        $result = Search_Result::findOrFail($request->idResult);


        if($result)
        {
            $result->statut = 'rejected';
            $result->save();
        }

        return response()->json($result);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Search  $search
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Search $search)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Search  $search
     * @return \Illuminate\Http\Response
     */
    public function destroy(Search $search)
    {
        //
    }
}
