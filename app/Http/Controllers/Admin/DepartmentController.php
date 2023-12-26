<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Admin\DepartmentRequest;
use App\Models\Role;
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
        $roles = Role::getAllRoles();
        return view('admin.department.upsert', [
            'id' => $id,
            'department' => $department,
            'employees' => $employees,
            'leaders' => $leaders,
            'roles' => $roles,
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
            $existingLeader = Department::where('leader_id', $request->input('leader_id'))
                ->where('id', '!=', $department->id)
                ->first();

            if ($existingLeader) {
                throw new \Exception('Trưởng phòng này đã được phân công.');
            }


            $existingRole = Department::where('role', $request->input('role'))
                ->where('id', '!=', $department->id)
                ->first();

            if ($existingRole) {
                throw new \Exception('Quyền này đã được phân cho phòng khác.');
            }
            $department->name = $request->input('name');
            $department->description = $request->input('description');
            $department->leader_id = $request->input('leader_id');
            $department->role = $request->input('role');
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
    public function updateEmployee(Request $request, $id){
        if($id){
            $user = User::findOrFail($id);
            $department = $request->post('department');
            if($department == null){
                $user->department_id = null;
                $user->save();
                return response()->json([
                    'status' => 0,
                    'message' => 'Xóa nhân viên ra khỏi phòng ban thành công',
                ]);
            }
            $user->department_id = $department;
            $user->save();
            return response()->json([
                'status' => 1,
                'message' => 'Thêm nhân viên vào phòng ban thành công',
            ]);
        }
    }
}
