<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;
use App\Http\Requests\ArtistRequest;

class ArtistsApiController extends Controller
{
    public function index(Request $request)
    {
        $artists = Artist::all();
        return response()->json([
            'artists' => $artists,
        ]);
    }

    public function store(ArtistRequest $request)
    {
        $artist = Artist::create($request->all());
        return response()->json(['artist' => $artist]);
    }

    public function update(ArtistRequest $request, $id)
    {
        $artist = Artist::findOrFail($id);
        $artist->update($request->all());
        return response()->json(['artist' => $artist]);
    }

    public function destroy($id)
    {
        $artist = Artist::findOrFail($id);
        $artist->delete();
        
        return response()->json(['message' => 'Artist deleted successfully', 'id' => $id]);
    }
}
