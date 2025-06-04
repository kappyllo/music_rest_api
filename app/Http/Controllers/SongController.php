<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song;

class SongController extends Controller 
{
    public function index(Request $request) {
        $songs = Song::orderBy("created_at","desc")->paginate(10);
        return response()->json($songs);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            "title" => ["required"],
            "artist" => ["required"],
            "album" => ["required"]
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

}