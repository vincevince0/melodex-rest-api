<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Requests\MemberRequest;

class MembersApiController extends Controller
{
    public function index(Request $request)
    {
        $members = Member::all();
        return response()->json([
            'members' => $members,
        ]);
    }

    public function store(MemberRequest $request)
    {
        $member = Member::create($request->all());
        return response()->json(['member' => $member]);
    }

    public function update(MemberRequest $request, $id)
    {
        $member = Member::findOrFail($id);
        $member->update($request->all());
        return response()->json(['member' => $member]);
    }
}
