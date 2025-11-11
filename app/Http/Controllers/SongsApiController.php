<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;
use App\Http\Requests\SongRequest;

class SongsApiController extends Controller
{
    public function index(Request $request)
    {
        $songs = Song::all();
        return response()->json([
            'songs' => $songs,
        ]);
    }

    public function store(SongRequest $request)
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

    public function update(SongRequest $request, $id)
    {
        $song = Song::findOrFail($id);
        $song->update($request->all());
        return response()->json(['song' => $song]);
    }

    public function destroy($id)
    {
        $song = Song::findOrFail($id);
        $song->delete();
        
        return response()->json(['message' => 'Song deleted successfully', 'id' => $id]);
    }
}
