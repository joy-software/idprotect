<?php

namespace App\Http\Controllers;

use App\Profile;
use App\Search;
use App\Search_Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

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
     * update a profile
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request)
    {
        $this->validate($request,[
            'email' => 'required'
        ]);


        $user = Auth::user();

        $user->name = $request->input('name');
        $user->nickname = $request->input('nickname');
        $user->email = $request->input('email');
        $user->profession = $request->input('profession');
        $user->save();

        $profile = $user->profile;

        if(count($profile) > 0)
        {
            $profile = $profile->first();
            $profile->p_name = $request->input('p_name');
            $profile->p_nickname = $request->input('p_nickname');
            $profile->p_email = $request->input('p_email');
            $profile->p_profession = $request->input('p_profession');
            //$profile->user()->associate($user);
            $profile->save();
        }
        else
        {
            $profile = new Profile();

            $profile->p_name = $request->input('p_name');
            $profile->p_nickname = $request->input('p_nickname');
            $profile->p_email = $request->input('p_email');
            $profile->p_profession = $request->input('p_profession');
            $profile->user()->associate($user);
            $profile->save();
        }

        return response()->json("ok");

    }

    public function avatar(Request $request){

        // Handle the user upload of avatar
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $filename ) );

            $user = Auth::user();
            $user->avatar = $filename;
            $user->save();
        }

        return redirect('/en/home');

    }

    public function load(Request $request){

        // Handle the user upload of avatar
        $user = Auth::user();

        $searchs = $user->search;
        $profile = $user->profile;
        if(count($profile) > 0)
        {
            $profile = $profile->first();
            $profile->name = $user->name;
            $profile->nickname = $user->nickname;
            $profile->email = $user->email;
            $profile->profession = $user->profession;
            $profile->avatar = $user->avatar;
        }


       $results = [];


        if(count($searchs) > 0)
        {
            foreach ($searchs as $search)
            {
               // $search = $search->first();
                $result_ = [];
                array_push($result_,$search->searchProfile);
                $results = array_merge($results,$result_);
            }

           // $search = Search::findOrFail($search->id);

        }

        $data['results'] = $results[0];
        $data['profile']=$profile;

        return response()->json($data);

    }

    public function p_load(Request $request){

        // Handle the user upload of avatar
        $search = Search::whereKeywords(strtolower($request->input('keywords')))->get()->first();

        $user = null;
        $results = [];
        $profile = null;

        if($search)
        {
            $user = $search->user;
        }

        if($user)
        {
            $searchs = $user->search;
            $profile = $user->profile;
            if(count($profile) > 0)
            {
                $profile = $profile->first();
                $profile->name = $user->name;
                $profile->nickname = $user->nickname;
                $profile->email = $user->email;
                $profile->profession = $user->profession;
                $profile->avatar = $user->avatar;
            }





            if(count($searchs) > 0)
            {
                foreach ($searchs as $search)
                {
                    // $search = $search->first();
                    $result_ = [];
                    array_push($result_,$search->searchProfile);
                    $results = array_merge($results,$result_);
                }

                // $search = Search::findOrFail($search->id);

            }


        }

        if(count($results) > 0)
        {
            $data['results'] = $results[0];
        }
        else
        {
            $data['results'] = $results;
        }

        $data['profile']=$profile;

        return response()->json($data);

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
