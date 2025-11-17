<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;
use App\Http\Requests\ArtistRequest;

class ArtistsApiController extends Controller
{
    /**
     * @api {get} /artists Get list of artists
     * @apiName indexArtists
     * @apiGroup Artists
     * @apiVersion 1.0.0
     *
     * @apiSuccess {Object[]} artists List of artists.
     */
    public function index(Request $request)
    {
        $artists = Artist::all();
        return response()->json([
            'artists' => $artists,
        ]);
    }

    /**
     * @api {post} /artists Add a new artist
     * @apiName createArtist
     * @apiGroup Artists
     * @apiVersion 1.0.0
     *
     * @apiBody {String} name Mandatory artist name.
     *
     * @apiParamExample {json} Request-Example:
     *      {
     *          "name": "New Artist"
     *      }
     *
     * @apiSuccess {Object} artist Created artist.
     */
    public function store(ArtistRequest $request)
    {
        $artist = Artist::create($request->all());
        return response()->json(['artist' => $artist]);
    }

    /**
     * @api {put} /artists/:id Update artist
     * @apiName updateArtist
     * @apiGroup Artists
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} id Artist unique ID.
     *
     * @apiParamExample {json} Request-Example:
     *      {
     *          "name": "Updated Artist"
     *      }
     *
     * @apiSuccess {Object} artist Updated artist.
     */
    public function update(ArtistRequest $request, $id)
    {
        $artist = Artist::findOrFail($id);
        $artist->update($request->all());
        return response()->json(['artist' => $artist]);
    }

    /**
     * @api {delete} /artists/:id Delete artist
     * @apiName deleteArtist
     * @apiGroup Artists
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} id Artist unique ID.
     *
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
     *      {
     *          "message": "Artist deleted successfully",
     *          "id": 3
     *      }
     */
    public function destroy($id)
    {
        $artist = Artist::findOrFail($id);
        $artist->delete();
        
        return response()->json(['message' => 'Artist deleted successfully', 'id' => $id]);
    }
}
