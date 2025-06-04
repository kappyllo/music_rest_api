<?php

namespace App\Http\Controllers;

use App\Models\album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{

    public function index()
    {
        $album = Album::all();
        return response()->json($album); 
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "title"=> ["required"],
            "artist_id"=>["required", "exists:artists,id"],
            "release_date"=>["required"],
        ]);

        $album = Album::create($validated);
        return response()->json($album, 201);
    }

    public function show($id)
    {
        $album = Album::find($id);
        return response()->json( $album );
    }
}
