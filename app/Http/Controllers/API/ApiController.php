<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $q = $request->query->get('q');

        if (!isset($q) || $q == null || $q == '') {
            return response()->json(['error' => 'No query string provided'], 400);
        }
        $q = htmlspecialchars(trim(strtolower($q)));
        if (cache()->has($q)) {
            return response()->json(cache()->get($q), 200);
        }


        $endpoint = "http://api.tvmaze.com/search/shows";
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $endpoint, [
            'query' => [
                'q' => $q
            ]
        ]);

        $statusCode = $response->getStatusCode();
        if ($statusCode == 200) {
            $body = $response->getBody();
            $data = json_decode($body);
            $data = array_filter($data, function ($item) {
                global $q;
                return strtolower($item->show->name) == $q;
            });
            cache()->put($q, $data);
            return response()->json($data, 200);
        } else {
            return response()->json(['error' => 'Error'], $statusCode);
        }
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->json(['message' => 'access denied'], 403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        return response()->json(['message' => 'access denied'], 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return response()->json(['message' => 'access denied'], 403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        return response()->json(['message' => 'access denied'], 403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        return response()->json(['message' => 'access denied'], 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return response()->json(['message' => 'access denied'], 403);
    }
}
