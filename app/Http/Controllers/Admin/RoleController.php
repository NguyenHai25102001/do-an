<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoleModel;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        if (User::checkUserRole(9)) {
            $titlePage = 'Nhân viên hệ thống';
            $page_menu = 'role';
            $page_sub = null;
            $listData = RoleModel::paginate(10);
            foreach ($listData as $item) {
                $item['user'] = User::find($item->user_id);
            }
            return view('admin.role.index', compact('titlePage', 'page_menu', 'listData', 'page_sub'));
        }else{
            return view('admin.error');
        }
    }

    public function create()
    {
        if (User::checkUserRole(9)) {
            $titlePage = 'Thêm nhân viên';
            $page_menu = 'role';
            $page_sub = null;
            return view('admin.role.create', compact('titlePage', 'page_menu', 'page_sub'));
        }else{
            return view('admin.error');
        }
    }


    public function store(Request $request)
    {
        try {
            if (empty($request->arr)){
                return back()->with('error', 'Lựa chọn ít nhất 1 quyền truy cập!');
            }
            $arr = $request->arr;
            $arr = json_encode(array_keys($arr));
            $user = new User();
            $user->name = $request->name??'';
            $user->phone = $request->phone??0;
            $user->password = bcrypt($request->password);

            $user->save();
            $role = new RoleModel();
            $role->user_id = $user->id;
            $role->role = $request->role;
            $role->role_name = $this->checkRule($request->role);
            $role->arr_role = $arr;
            $role->save();

            return \redirect()->route('admin.role.index')->with(['success' => 'Thêm thành công']);
        }catch (\Exception $exception){
            dd($exception->getMessage());
        }
    }

    public function edit($id)
    {
        if (User::checkUserRole(9)) {
            $titlePage = 'Sửa nhân viên';
            $page_menu = 'role';
            $page_sub = null;
            $data = User::find($id);
            $role = RoleModel::where('user_id', $id)->first();
            $arr = [];
            if ($role) {
                $arr = json_decode($role->arr_role);
            }

            return view('admin.role.edit', compact('titlePage', 'page_menu', 'page_sub', 'data', 'role', 'arr'));
        }else{
            return view('admin.error');
        }
    }

    public function update(Request $request, $id){
        try {
            if (empty($request->arr)){
                return back()->with('error', 'Lựa chọn ít nhất 1 quyền truy cập!');
            }
            $arr = $request->arr;
            $arr = json_encode(array_keys($arr));
            $user = User::find($id);
            $user->name = $request->name??'';
            $user->phone = $request->phone??0;
            $user->password = bcrypt($request->password);
            $user->save();

            $role = RoleModel::where('user_id', $id)->first();
            $role->role = $request->role;
            $role->role_name = $this->checkRule($request->role);
            $role->arr_role = $arr;
            $role->save();

            return \redirect()->route('admin.role.index')->with(['success' => 'Sửa thành công']);
        }catch (\Exception $exception){
            dd($exception->getMessage());
        }
    }

    public function delete($id){
        try {
            if (User::checkUserRole(9)) {
                $user = User::find($id);
                $user->delete();
                $rule = RoleModel::where('user_id', $id)->first();
                $rule->delete();

                return \redirect()->route('admin.role.index')->with(['success' => 'Xoá thành công']);
            }else{
                return view('admin.error');
            }
        }catch (\Exception $exception){
            dd($exception->getMessage());
        }
    }

    private function checkRule($rule_id){
        if ($rule_id == 2){
            $name = 'Giám đốc';
        }elseif ($rule_id == 3){
            $name = 'Trưởng phòng';
        }elseif ($rule_id == 4){
            $name = 'Chuyên viên';
        }elseif ($rule_id == 5){
            $name = 'Giám sát viên';
        }else{
            $name = 'Chủ tịch';
        }
        return $name;
    }
}
