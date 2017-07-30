<?php

namespace App\Http\Controllers\Admin;

use App\Models\Api;
use Illuminate\Http\Request;
class ApiController extends AdminBaseController
{
    public function index(Request $request)
    {
        $mod = new Api();

        $data = $mod->orderBy('created_at', 'desc')->paginate(config('admin.page-size'));

        return view('admin.api.index', compact('data'));
    }

    public function show($id)
    {
        $data = Api::findOrFail($id);

        return view('admin.api.show', compact('data'));
    }

    public function create()
    {
        return view('admin.api.create');
    }

    public function store(Request $request)
    {
        $validator = $this->verify($request, 'api.store');

        if ($validator->fails())
        {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }

        $data = $request->all();

        Api::create($data);

        return responseSuccess('', '', route('api.index'));

    }

    public function edit($id)
    {
        $data = Api::findOrFail($id);

        return view('admin.api.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validator = $this->verify($request, 'api.store');

        if ($validator->fails())
        {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }

        $mod = Api::findOrFail($id);

        $mod->update($request->all());

        return responseSuccess('', '', route('api.index'));

    }

    public function destroy($id)
    {
        Api::destroy($id);

        return respS();
    }

    public function check($id, $status)
    {
        $mod = Api::findOrFail($id);

        $mod->update([
            'on_line' => $status
        ]);

        return respS();
    }
}
