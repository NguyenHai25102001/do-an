<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BannerModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        if (User::checkUserRole(3)) {
            $titlePage = 'Danh sách banner';
            $page_menu = 'banner';
            $page_sub = null;
            if (isset($request->key_search)) {
                $listData = BannerModel::Where('title', 'like', '%' . $request->get('key_search') . '%')
                    ->orderBy('location', 'asc')->paginate(10);
            } else {
                $listData = BannerModel::orderBy('location', 'asc')->paginate(10);
            }

            return view('admin.banner.index', compact('titlePage', 'page_menu', 'page_sub', 'listData'));
        }else{
            return view('admin.error');
        }
    }

    public function create ()
    {
        try{
            if (User::checkUserRole(3)) {
                $titlePage = 'Admin';
                $page_menu = 'banner';
                $page_sub = 'create';
                return view('admin.banner.create', compact('titlePage', 'page_menu', 'page_sub'));
            }else{
                return view('admin.error');
            }
        }catch (\Exception $e){
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    public function store (Request $request)
    {
        try{
            if (!$request->hasFile('file')){
                return back()->with(['error' => 'Vui lòng thêm hình ảnh']);
            }
            $file = $request->file('file');
            $part = 'upload/banner/img/';
            if ($request->get('display') == 'on'){
                $display = 1;
            }else{
                $display = 0;
            }
            $file_name = $part.Str::random(40). '.'. $file->getClientOriginalExtension();
            $request->file('file')->move($part, $file_name);
            $banner = new BannerModel([
                'title' => $request->get('title'),
                'link' => $request->get('link'),
                'location' => $request->get('location'),
                'index' => $request->get('index'),
                'display' => $display,
                'image' => $file_name
            ]);
            $banner->save();
            return redirect()->route('admin.banner.index')->with(['success' => 'Tạo banner thành công']);
        }catch (\Exception $exception){
            return back()->with(['error' => $exception->getMessage()]);
        }
    }

    public function delete ($id)
    {
        if (User::checkUserRole(3)) {
            $banner = BannerModel::find($id);
            if (empty($banner)) {
                $data['status'] = false;
                $data['msg'] = 'Banner không tồn tại';
                return $data;
            }
            unlink($banner->src);
            $banner->delete();
            $data['status'] = true;
            return $data;
        }else{
            return view('admin.error');
        }
    }

    public function edit ($id)
    {
        try{
            if (User::checkUserRole(3)) {
                $banner = BannerModel::find($id);
                if (empty($banner)) {
                    return back()->with(['error' => 'Banner không tồn tại']);
                }
                $titlePage = 'Admin';
                $page_menu = 'banner';
                $page_sub = null;
                return view('admin.banner.edit', compact('titlePage', 'page_menu', 'page_sub', 'banner'));
            }else{
                return view('admin.error');
            }
        }catch (\Exception $exception){
            return back()->with(['error' => $exception->getMessage()]);
        }
    }

    public function update ($id, Request $request)
    {
        try{
            $banner = BannerModel::find($id);
            if (empty($banner)){
                return back()->with(['error' => 'Banner không tồn tại']);
            }
            if ($request->hasFile('file')){
                $file = $request->file('file');
                $part = 'upload/banner/img/';
                $file_name = $part.Str::random(40). '.'. $file->getClientOriginalExtension();
                $request->file('file')->move($part, $file_name);
                unlink($banner->image);
                $banner->image = $file_name;
            }
            if ($request->get('display') == 'on'){
                $display = 1;
            }else{
                $display = 0;
            }
            $banner->display = $display;
            $banner->title = $request->get('title');
            $banner->link = $request->get('link');
            $banner->index = $request->get('index');
            $banner->save();
            return redirect()->route('admin.banner.index')->with(['success' => 'Cập nhật banner thành công']);
        }catch (\Exception $e){
            return back()->with(['error' => $e->getMessage()]);
        }
    }
}
