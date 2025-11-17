<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use App\Http\Requests\AlbumRequest;

class AlbumsApiController extends Controller
{
    /**
     * @api {get} /albums Get list of albums
     * @apiName indexAlbums
     * @apiGroup Albums
     * @apiVersion 1.0.0
     *
     * @apiSuccess {Object[]} albums List of albums.
     *
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
     *      {
     *          "albums":[]
     *      }
     */
    public function index(Request $request)
    {
        $albums = Album::all();
        return response()->json([
            'albums' => $albums,
        ]);
    }

    /**
     * @api {post} /albums Add a new album
     * @apiName createAlbum
     * @apiGroup Albums
     * @apiVersion 1.0.0
     *
     * @apiBody {String} name Mandatory album name.
     *
     * @apiParamExample {json} Request-Example:
     *      {
     *          "name": "New Album"
     *      }
     *
     * @apiSuccess {Object} album Created album object.
     */
    public function store(AlbumRequest $request)
    {
        $album = Album::create($request->all());
        return response()->json(['album' => $album]);
    }

    /**
     * @api {put} /albums/:id Update album
     * @apiName updateAlbum
     * @apiGroup Albums
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} id Album unique ID.
     *
     * @apiParamExample {json} Request-Example:
     *      {
     *          "name": "Updated Album Title"
     *      }
     *
     * @apiSuccess {Object} album Updated album object.
     */
    public function update(AlbumRequest $request, $id)
    {
        $album = Album::findOrFail($id);
        $album->update($request->all());
        return response()->json(['album' => $album]);
    }

    /**
     * @api {delete} /albums/:id Delete album
     * @apiName deleteAlbum
     * @apiGroup Albums
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} id Album unique ID.
     *
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
     *      {
     *          "message": "Album deleted successfully",
     *          "id": 5
     *      }
     */
    public function destroy($id)
    {
        $album = Album::findOrFail($id);
        $album->delete();
        
        return response()->json(['message' => 'Album deleted successfully', 'id' => $id]);
    }
}
