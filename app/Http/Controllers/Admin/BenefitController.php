<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BenefitRequest;
use App\Models\Benefit;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class BenefitController extends Controller
{
    //
    public function index(Request $request){
        $limit = 10;
        $all = null;
        $search = $request->input('search', '');
        $benefits = Benefit::getAllBenefits($limit, $search ,$all );
        return view('admin.benefits.index',[
            'search' => $search,
            'benefits' => $benefits,
        ]);
    }

    public function viewUpsert($id = null)
    {
        $benefit = $id ? Benefit::findOrFail($id) : null; 
        return view('admin.benefits.upsert',[
            "id" => $id,
            "benefit" => $benefit,
        ]);
    }

    public function store(BenefitRequest $request, $id = null)
    {
        if ($id === null) {
            $benefit = new Benefit();
        } else {
            $benefit = Benefit::findOrFail($id);
        }
        try {
            $benefit->name = $request->input('name');
            $benefit->description = $request->input('description');
            $benefit->policy = $request->input('policy');
            $benefit->price = $request->input('price');
            $benefit->save();
            if ($id === null) {
                Session::flash('success', 'Thêm mới phúc lợi thành công');
            } else {
                Session::flash('success', 'Cập nhật phúc lợi thành công');
            }
            return redirect()->back();
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }
}
