<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class SongsApiController extends Controller
{
    public function index(Request $request)
    {
        $songs = Song::all();
        return response()->json([
            'songs' => $songs,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'lyrics' => 'required|string|min:2',
            'songwriter' => 'required|string|min:2',
            'album_id' => 'required|numeric',
        ]);
        $song = Song::create($request->all());
        return response()->json(['song' => $song]);
    }
}
