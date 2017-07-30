<?php

namespace App\Http\Controllers\Daili;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ValidationTrait;
use App\Models\Member;
class MemberDailiController extends DailiBaseController
{
    use ValidationTrait;
    public function index(Request $request)
    {
        $mod = new Member();

        $data = $mod->where('is_daili', 1)->where('id', $this->getDaili()->id)->orderBy('created_at', 'desc')->paginate(config('admin.page-size'));

        return view('daili.member_daili.index', compact('data', 'name'));
    }

    /**
     *
     * 编辑
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $data= Member::findOrFail($id);

        return view('admin.member_daili.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $member= Member::findOrFail($id);

        $member->update($request->all());

        return responseSuccess('','', route('member_daili.index'));
    }
}
