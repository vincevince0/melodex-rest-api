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
}
