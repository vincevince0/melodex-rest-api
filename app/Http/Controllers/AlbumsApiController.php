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
}
