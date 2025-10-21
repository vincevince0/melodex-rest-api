<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumsApiController extends Controller
{
    public function index(Request $request)
    {
        $albums = Album::all();
        return response()->json([
            'albums' => $albums,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'cover' => 'required|string|min:2',
            'year' => 'required|numeric',
            'genre' => 'required|string|min:2',
            'artist_id' => 'required|numeric',
        ]);
        $album = Album::create($request->all());
        return response()->json(['album' => $album]);
    }
}
