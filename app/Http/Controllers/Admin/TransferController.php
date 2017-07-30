<?php

namespace App\Http\Controllers\Admin;

use App\Models\Member;
use App\Models\Transfer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransferController extends Controller
{
    public function index(Request $request)
    {
        $mod = new Transfer();
        $name = $type = $transfer_type = $transfer_in_account = $transfer_out_account = $start_at = $end_at = '';
        if ($request->has('name'))
        {
            $name = $request->get('name');
            $m_list = Member::where('name', 'LIKE', "%$name%")->pluck('id');
            $mod = $mod->whereIn('member_id', $m_list);
        }
        if ($request->has('transfer_in_account'))
        {
            $transfer_in_account = $request->get('transfer_in_account');
            $mod = $mod->where('transfer_in_account', 'LIKE', "%$transfer_in_account%");
        }
        if ($request->has('transfer_out_account'))
        {
            $transfer_out_account = $request->get('transfer_out_account');
            $mod = $mod->where('transfer_out_account', 'LIKE', "%$transfer_in_account%");
        }
        if ($request->has('transfer_type'))
        {
            $transfer_type = $request->get('transfer_type');
            $mod = $mod->where('transfer_type', $transfer_type);
        }
        if ($request->has('start_at'))
        {
            $start_at = $request->get('start_at');
            $mod = $mod->where('created_at', '>=', $start_at);
        }
        if ($request->has('end_at'))
        {
            $end_at = $request->get('end_at');
            $mod = $mod->where('created_at', '<=',$end_at);
        }

        $data = $mod->orderBy('created_at', 'desc')->paginate(config('admin.page-size'));

        return view('admin.transfer.index', compact('data', 'name', 'transfer_in_account', 'transfer_out_account', 'transfer_type', 'start_at', 'end_at'));
    }
}
