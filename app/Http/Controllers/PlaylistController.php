<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    public function index()
    {
        $playlist = Playlist::with(["user", "songs"])->orderBy("created_at")->paginate(10);

        return response()->json($playlist);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "name"=> "required"
        ]);

        $playlist = new Playlist();

        $playlist->name = $validated["name"];
        $playlist->user_id = auth()->id();

        $playlist->save();

        return response()->json($playlist, 201);


    }

    public function addSong(Request $request, $id)
    {
        $validated = $request->validate([
            "song_id"=> ["required", "integer", "exists:songs,id"],
        ]);

        $playlist = Playlist::findOrFail($id);

        if ($playlist->user_id !== auth()->id()) {
            abort(403, "It is not your playlist.");
        }

        $playlist->songs()->attach($validated["song_id"]);

        return response()->json($playlist->load('songs'), 200);
        
    }

    public function show($id)
    {
        $playlist = Playlist::find($id);
        return response()->json($playlist);
    }

    public function removeSong(Request $request, $id)
    {
        $playlist = Playlist::findOrFail($id);

        if ($playlist->user_id !== auth()->id()) {
            abort(403, "It is not your playlist.");
        }

        $playlist->songs()->detach($request->song_id);

        return response()->json($playlist->load('songs'), 200);
    }
}
