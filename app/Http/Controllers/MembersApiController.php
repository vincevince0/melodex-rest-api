<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MembersApiController extends Controller
{
    public function index(Request $request)
    {
        $members = Member::all();
        return response()->json([
            'members' => $members,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'instruement' => 'required|string|min:2',
            'year' => 'required|numeric',
            'artist_id' => 'required|numeric',
            'image' => 'required|string|min:2',
        ]);
        $member = Member::create($request->all());
        return response()->json(['member' => $member]);
    }
}
