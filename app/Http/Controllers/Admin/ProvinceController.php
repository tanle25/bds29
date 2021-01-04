<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.pages.provinces.index');
    }

    function list(Request $request) {

        return DataTables::eloquent($provinces)
            ->addColumn('action', function ($province) {
                return '
            <a data-toggle-for="tooltip" title="Sửa thông tin" href="' . route('admin.province.edit', $province->id) . '"class="btn text-info province-edit"><i class="fas fa-edit" data-toggle="modal" data-target="#province-model"></i></a>
            <a data-toggle-for="tooltip" title="Xóa" href="' . route('admin.province.destroy', $province->id) . '"class="btn text-danger province-destroy"><i class="fas fa-trash" data-toggle="modal" data-target="#province-model"></i></a>
            ';
            })
            ->rawColumns(['action', 'link'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.pages.provinces.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $province = province::findOrCreateFromString($request->name);
        $province->type = $request->type;
        $province->save();
        if ($request->submit == 'save') {
            return redirect()->route('admin.province.edit', $province->id)->with('success', 'Cập nhật thành công dự án');
        }
        return redirect()->route('admin.province.index')->with('success', 'Cập nhật thành công dự án');
    }

    public function edit($id)
    {
        $province = Province::findOrFail($id);

        return view('admin.pages.provinces.edit', compact('province'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $province = province::findOrFail($id);
        $province->name = $request->name;
        $province->type = $request->type;
        $province->save();
        if ($request->submit == 'save') {
            return redirect()->route('admin.province.edit', $province->id)->with('success', 'Cập nhật thành công dự án');
        }
        return redirect()->route('admin.province.index')->with('success', 'Cập nhật thành công dự án');
    }

    public function destroy($id)
    {
        Province::findOrFail($id)->delete();
        return ['msg' => 'Xóa thành công tỉnh!'];
    }
}