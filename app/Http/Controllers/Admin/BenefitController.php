<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BenefitRequest;
use App\Models\Benefit;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BenefitController extends Controller
{
    //
    public function index(Request $request)
    {
        $limit = 10;
        $all = null;
        $search = $request->input('search', '');
        $benefits = Benefit::getAllBenefits($limit, $search, $all);
        return view('admin.benefits.index', [
            'search' => $search,
            'benefits' => $benefits,
        ]);
    }

    public function viewUpsert($id = null)
    {
        $benefit = $id ? Benefit::findOrFail($id) : null;
        return view('admin.benefits.upsert', [
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
            if ($benefit->file_path) {
                Storage::delete($benefit->file_path);
            }
        }
        try {
            $benefit->name = $request->input('name');
            $benefit->description = $request->input('description');
            $benefit->policy = $request->input('policy');
            $benefit->price = $request->input('price');
            // Kiểm tra xem có tệp tin được tải lên không
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                
                $fileName = $file->getClientOriginalName() ;
    
                $filePath = $file->storeAs('benefit_files', $fileName);
                
                $benefit->file_path = $filePath;
            }
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
    public function destroy($id = null)
    {
        $benefit = Benefit::where('id', $id)->first();

        if ($benefit) {
            $deleted = $benefit->delete();
            if ($deleted) {
                return response()->json([
                    'success' => 'Xóa phúc lợi thành công.',
                    'id' => $benefit->id,
                ]);
            } else {
                return response()->json([
                    'error' => 'Xóa phúc lợi thất bại.'
                ]);
            }
        } else {
            return response()->json([
                'error' => 'phúc lợi không tồn tại.'
            ]);
        }
    }
    public function download($id)
    {
        $benefit = Benefit::findOrFail($id);
    
        if (Storage::exists($benefit->file_path) ) {
            $file = Storage::path($benefit->file_path);
            
            return response()->download($file);
        } else {
            abort(404);
        }
    }
}
