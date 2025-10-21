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
        request()

        return response()->json(['artist' => $artist,]);
    }
}
