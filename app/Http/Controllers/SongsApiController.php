<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;
use App\Http\Requests\SongRequest;

class SongsApiController extends Controller
{
    /**
     * @api {get} /songs Get list of songs
     * @apiName indexSongs
     * @apiGroup Songs
     * @apiVersion 1.0.0
     *
     * @apiSuccess {Object[]} songs List of songs.
     */
    public function index(Request $request)
    {
        $songs = Song::all();
        return response()->json([
            'songs' => $songs,
        ]);
    }

    /**
     * @api {post} /songs Add a new song
     * @apiName createSong
     * @apiGroup Songs
     * @apiVersion 1.0.0
     *
     * @apiBody {String} name Song name.
     * @apiBody {String} lyrics Song lyrics.
     * @apiBody {String} songwriter Songwriter.
     * @apiBody {Number} album_id Album ID.
     *
     * @apiParamExample {json} Request-Example:
     *      {
     *          "name": "New Song",
     *          "lyrics": "lorem ipsum",
     *          "songwriter": "John Doe",
     *          "album_id": 4
     *      }
     *
     * @apiSuccess {Object} song Created song.
     */
    public function store(SongRequest $request)
    {

        $song = Song::create($request->all());
        return response()->json(['song' => $song]);
    }

    /**
     * @api {put} /songs/:id Update song
     * @apiName updateSong
     * @apiGroup Songs
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} id Song unique ID.
     *
     * @apiParamExample {json} Request-Example:
     *      {
     *          "name": "Updated Song"
     *      }
     *
     * @apiSuccess {Object} song Updated song data.
     */
    public function update(SongRequest $request, $id)
    {
        $song = Song::findOrFail($id);
        $song->update($request->all());
        return response()->json(['song' => $song]);
    }

    /**
     * @api {delete} /songs/:id Delete song
     * @apiName deleteSong
     * @apiGroup Songs
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} id Song ID.
     *
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
     *      {
     *          "message": "Song deleted successfully",
     *          "id": 8
     *      }
     */
    public function destroy($id)
    {
        $song = Song::findOrFail($id);
        $song->delete();
        
        //return response()->json(['message' => 'Song deleted successfully', 'id' => $id]);
        return response()->json(['message' => 'Deleted'], 410);
    }
}
