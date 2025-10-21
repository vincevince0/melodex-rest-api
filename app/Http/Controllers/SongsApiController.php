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
}
