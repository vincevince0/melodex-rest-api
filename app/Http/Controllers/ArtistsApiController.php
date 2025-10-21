<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistsApiController extends Controller
{
    public function index(Request $request)
    {
        $artists = Artist::all();
        return response()->json([
            'artists' => $artists,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'nationality' => 'required|string|min:2',
            'image' => 'nullable|string',
            'description' => 'required|string|min:2',
            'is_band' => 'required|string|min:2',
        ]);
        $artist = Artist::create($request->all());
        return response()->json(['artist' => $artist]);
    }
}
