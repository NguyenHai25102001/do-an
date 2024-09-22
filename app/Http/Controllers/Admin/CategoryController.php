<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index (Request $request)
    {
        if (User::checkUserRole(5)) {
            $titlePage = 'Admin | Danh Mục Sản Phẩm';
            $page_menu = 'products';
            $page_sub = 'category';
            if (isset($request->key_search)) {
                $listData = CategoryModel::Where('name', 'like', '%' . $request->get('key_search') . '%')
                    ->orderBy('created_at', 'desc')->paginate(10);
            } else {
                $listData = CategoryModel::paginate(10);
            }
            foreach ($listData as $item) {
                $category = CategoryModel::find($item->parent_id);
                $item->category_parent = $category->name ?? 'Là danh mục cha';
            }
            return view('admin.category.index', compact('titlePage', 'page_menu', 'listData', 'page_sub'));
        }else{
            return view('admin.error');
        }
    }

    public function create()
    {
        if (User::checkUserRole(5)) {
            $titlePage = 'Admin | Danh Mục Sản Phẩm';
            $page_menu = 'products';
            $page_sub = 'category';
            $category = CategoryModel::where('parent_id', 0)->get();
            return view('admin.category.create', compact('titlePage', 'page_menu', 'page_sub', 'category'));
        }else{
            return view('admin.error');
        }
    }

    public function store (Request $request)
    {
        try{
            $slug = Str::slug($request->get('name'));
            $category_slug= CategoryModel::where('slug', $slug)->first();
            if (isset($category_slug)){
                return \redirect()->back()->with(['error' => 'Tên danh mục đã tồn tại']);
            }
            if ($request->hasFile('file')){
                $file = $request->file('file');
                $part = 'upload/banner/img/';
                $file_name = $part.Str::random(40). '.'. $file->getClientOriginalExtension();
                $request->file('file')->move($part, $file_name);
            }
            $category = new CategoryModel();
            $category['name'] = $request->get('name');
            $category['slug'] = $slug;
            $category['image'] = $file_name;
            $category['parent_id'] = $request->get('parent_id');
            $category['type'] = $request->get('type');
            $category['location'] = $request->get('location');
            $category['display'] = $request->get('display');
            $category->save();
            return \redirect()->route('admin.category.index')->with(['success' => 'Tạo mới danh mục thành công']);
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    public function delete ($id)
    {
        if (User::checkUserRole(5)) {
            $category = CategoryModel::find($id);
            $category->delete();
            return \redirect()->route('admin.category.index')->with(['success' => 'Xóa danh mục thành công']);
        }else{
            return view('admin.error');
        }
    }

    public function edit ($id)
    {
        if (User::checkUserRole(5)) {
            $category = CategoryModel::find($id);
            $titlePage = 'Admin | Danh Mục Sản Phẩm';
            $page_menu = 'products';
            $page_sub = 'category';
            $category_all = CategoryModel::where('parent_id', 0)->get();
            return view('admin.category.edit', compact('category', 'titlePage', 'page_menu', 'page_sub', 'category_all'));
        }else{
            return view('admin.error');
        }
    }

    public function update (Request $request , $id)
    {
        try{
            $slug = Str::slug($request->get('name'));
            $category = CategoryModel::find($id);
            $_category = CategoryModel::where('slug', $slug)->first();
            if (isset($_category) && ($category->id != $_category->id)){
                return \redirect()->back()->with(['error' => 'Tên danh mục đã tồn tại']);
            }
            if ($request->hasFile('file')){
                $file = $request->file('file');
                $part = 'upload/banner/img/';
                $file_name = $part.Str::random(40). '.'. $file->getClientOriginalExtension();
                $request->file('file')->move($part, $file_name);
                unlink($category->image);
                $category->image = $file_name;
            }
            $category->name = $request->get('name');
            $category->slug = $slug;
            $category->type = $request->get('type');
            $category->parent_id = $request->get('parent_id');
            $category->location = $request->get('location');
            $category->display = $request->get('display');
            $category->save();
            return \redirect()->route('admin.category.index')->with(['success' => 'Cập nhập danh mục thành công']);
        }catch (\Exception $exception){
            return back()->with(['error' => $exception->getMessage()]);
        }
    }

    /**
     *  get children category cấp 2
     **/
    public function getChildrenC2 (Request $request)
    {
        try{
            $listCategory = CategoryModel::where('type', $request->get('type'))->where('parent_id',0)->where('display', 1)
                ->orderBy("location", "asc")->get();
            $html = null;
            if (count($listCategory)){
                foreach ($listCategory as $value){
                    $option = '<div class="d-flex align-items-center category list_category_children p-1">
                                                <div class="d-flex align-items-center" style="margin-right: 10px"><input type="checkbox" id="'.$value->id.'" style="width: 20px; height: 20px" value="'.$value->id.'" name="'.$request->get('name').'"></div>
                                                <label for="'.$value->id.'" class="m-0">'.$value->name.'</label>
                                            </div>';
                    $html .= $option;
                }
            }
            $data['html'] = $html;
            $data['status'] = true;
            $data['name'] = $request->get('name');
            return $data;
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
    /**
     *  get children category cấp 3
     **/
    public function getChildrenC3 (Request $request)
    {
        try{
            $listCategory = CategoryModel::where('parent_id',$request->get('category_child'))->where('display', 1)
                ->orderBy("location", "asc")->get();
            $html = null;
            if (count($listCategory)){
                foreach ($listCategory as $value){
                    $option = '<div class="d-flex align-items-center category list_category_children p-1">
                                                <div class="d-flex align-items-center" style="margin-right: 10px"><input type="checkbox" id="'.$value->id.'" style="width: 20px; height: 20px" value="'.$value->id.'" name="'.$request->get('name').'"></div>
                                                <label for="'.$value->id.'" class="m-0">'.$value->name.'</label>
                                            </div>';
                    $html .= $option;
                }
            }
            $data['html'] = $html;
            $data['status'] = true;
            $data['name'] = $request->get('name');
            return $data;
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
}
