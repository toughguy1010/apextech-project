<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Admin\DepartmentRequest;
use App\Models\User;
use Illuminate\Http\Request;


class DepartmentController extends Controller
{
    //
    public function index(Request $request)
    {
        $limit = 5;
        $all = null;
        $search = $request->input('search', '');
        $departments = Department::getAllDepartment($limit, $search, $all);
        return view('admin.department.index', [
            'departments' => $departments,
            'search' => $search,

        ]);
    }

    public function viewUpsert($id = null)
    {
        $leaders = User::getUserLeader();
        $employees = User::getUserEmployee();
        $department = $id ? Department::findorFail($id) : null;
        return view('admin.department.upsert', [
            'id' => $id,
            'department' => $department,
            'employees' => $employees,
            'leaders' => $leaders,
        ]);
    }
    public function store(Request $request, $id = null)
    {
        if ($id === null) {
            $department = new Department();
        } else {
            $department = Department::findOrFail($id);
        }

        try {
            $department->name = $request->input('name');
            $department->description = $request->input('description');
            $department->leader_id = $request->input('leader_id');
            $department->save();
            if ($request->input('employees_id') > 0) {
                $employeeIds = $request->input('employees_id');
                User::whereIn('id', $employeeIds)->update(['department_id' => $department->id]);
            }
            if ($request->input('remove_employee') > 0) {
                $employeeIds = $request->input('remove_employee');
                User::whereIn('id', $employeeIds)->update(['department_id' => null]);
            }
            if ($id === null) {
                Session::flash('success', 'Thêm mới phòng ban thành công');
            } else {
                Session::flash('success', 'Cập nhật phòng ban thành công');
            }
            return redirect()->back();
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }
    public function destroy($id)
    {

        $department = Department::where('id', $id)->first();

        if ($department) {
            User::where('department_id', $id)->update(['department_id' => null]);
            $deleted = $department->delete();
            if ($deleted) {
                return response()->json([
                    'success' => 'Xóa phòng ban thành công.',
                    'id' => $id,
                ]);
            } else {
                return response()->json([
                    'error' => 'Xóa phòng ban thất bại.'
                ]);
            }
        } else {
            return response()->json([
                'error' => 'Phòng ban không tồn tại.'
            ]);
        }
    }
    public function search(Request $request)
    {
        $search = $request->input('search');
        $users = User::query()
            ->where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')
            ->get();
        $usersWithDepartments = [];
        foreach ($users as $user) {
            $departmentName = $user->getDepartmentName();
            $userWithDepartment = $user->toArray();
            $userWithDepartment['department_name'] = $departmentName;

            $usersWithDepartments[] = $userWithDepartment;
        }
        return response()->json([
            'users' => $usersWithDepartments,
        ]);
    }
}
