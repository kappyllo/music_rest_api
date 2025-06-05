<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function index()
    {
        $artists = Artist::with(["albums", "songs"])->orderBy("id")->paginate(10);
        return response()->json($artists);        
    }

    public function store(Request $request)
    {
        $artist = Artist::create($request->all());
        return response()->json($artist, 201);
    }

    public function show($id)
    {
        $artist = Artist::find($id);
        return response()->json($artist);
    }
    public function destroy($id)
    {
        $song = Artist::find($id);

        if (! $song) {
            return response()->json(["message"=> "song not found"],404);
        }

        $song->delete();

        return response()->json(["message"=> "Song deleted succesfully"],200);
    }
}
