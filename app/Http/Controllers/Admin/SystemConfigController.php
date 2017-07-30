<?php

namespace App\Http\Controllers\Admin;

use App\Models\SystemConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SystemConfigController extends Controller
{
    public function index()
    {
        $data = SystemConfig::findOrFail(1);

        return view('admin.system_config.index', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $mod = SystemConfig::findOrFail($id);
        $mod->update($request->all());

        return responseSuccess('', '', route('system_config.index'));
    }
}
