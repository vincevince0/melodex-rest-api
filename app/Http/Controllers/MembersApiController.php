<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Requests\MemberRequest;

class MembersApiController extends Controller
{
    /**
     * @api {get} /members Get list of members
     * @apiName indexMembers
     * @apiGroup Members
     * @apiVersion 1.0.0
     *
     * @apiSuccess {Object[]} members List of members.
     */
    public function index(Request $request)
    {
        $members = Member::all();
        return response()->json([
            'members' => $members,
        ]);
    }

    /**
     * @api {post} /members Add a new member
     * @apiName createMember
     * @apiGroup Members
     * @apiVersion 1.0.0
     *
     * @apiBody {String} name Member name.
     * @apiBody {String} role Member role.
     *
     * @apiParamExample {json} Request-Example:
     *      {
     *          "name": "Adam",
     *          "role": "Guitarist"
     *      }
     *
     * @apiSuccess {Object} member Created member.
     */
    public function store(MemberRequest $request)
    {
        $member = Member::create($request->all());
        return response()->json(['member' => $member]);
    }

    /**
     * @api {put} /members/:id Update member
     * @apiName updateMember
     * @apiGroup Members
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} id Member ID.
     *
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
     *      {
     *          "member": {"id":1,"name":"Adam","role":"Drummer"}
     *      }
     */
    public function update(MemberRequest $request, $id)
    {
        $member = Member::findOrFail($id);
        $member->update($request->all());
        return response()->json(['member' => $member]);
    }

    /**
     * @api {delete} /members/:id Delete member
     * @apiName deleteMember
     * @apiGroup Members
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} id Member unique ID.
     *
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
     *      {
     *          "message": "Member deleted successfully",
     *          "id": 1
     *      }
     */
    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();
        
        return response()->json(['message' => 'Member deleted successfully', 'id' => $id]);
    }
}
