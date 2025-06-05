<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song;

class SongController extends Controller 
{
    public function index() {
        $songs = Song::with(["artist", "album"])->orderBy("created_at")->paginate(10);
        return response()->json($songs);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            "title" => ["required"],
            "artist_id" => ["required", "exists:artists,id"],
            "album_id" => ["required", "exists:albums,id"]
        ]);

        $song = Song::create($validated);

        return response()->json([
            "message" => "song added",
            "song" => $song
        ], 201);
    }

    public function show($id) {
        $song = Song::find($id);
        if (!$song) {
            abort(404, "Song not found.");
        } else {
        return response()->json($song);
        }
    }

    public function destroy($id)
    {
        $song = Song::find($id);
        if (!$song) {
            abort(404, "Song not found");
        }

        $song->delete();
        return response()->json(["message" => "Song delated succesfully"], 200);
    }

}