<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index (Request $request)
    {
        if (User::checkUserRole(7)) {
            $titlePage = 'Danh sách bài viết';
            $page_menu = 'news';
            $page_sub = 'index';
            if (isset($request->key_search)) {
                $listData = NewsModel::Where('title', 'like', '%' . $request->get('key_search') . '%')
                    ->orderBy('created_at', 'desc')->paginate(10);
            } else {
                $listData = NewsModel::orderBy('created_at', 'desc')->paginate(10);
            }

            return view('admin.news.index', compact('titlePage', 'page_menu', 'listData', 'page_sub'));
        }else{
            return view('admin.error');
        }
    }
    public function create ()
    {
        if (User::checkUserRole(7)) {
            $titlePage = 'Bài viết';
            $page_menu = 'news';
            $page_sub = 'index';
            return view('admin.news.create', compact('titlePage', 'page_menu', 'page_sub'));
        }else{
            return view('admin.error');
        }
    }

    public function store(Request $request)
    {
        try {
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
            if ($request->get('is_featured') == 'on'){
                $is_featured = 1;
            }else{
                $is_featured = 0;
            }
            $file_name = $part.Str::random(40). '.'. $file->getClientOriginalExtension();
            $request->file('file')->move($part, $file_name);

            $news = new NewsModel();
            $news->title = $request->get('title');
            $news->slug = Str::slug($request->get('title'));
            $news->image = $file_name;
            $news->content = $request->get('content');
            $news->type = $request->get('type');
            $news->index = $request->get('index');
            $news->is_featured = $is_featured;
            $news->display = $display;
            $news->save();

            return \redirect()->route('admin.news.index')->with(['success' => 'Thêm tin tức thành công']);

        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    public function delete ($id)
    {
        if (User::checkUserRole(7)) {
            NewsModel::where('id', $id)->delete();
            return \redirect()->route('admin.news.index')->with(['success' => 'Xóa tin tức thành công']);
        }else{
            return view('admin.error');
        }
    }

    public function edit ($id)
    {
        if (User::checkUserRole(7)) {
            $news = NewsModel::find($id);
            $titlePage = 'Bài viết';
            $page_menu = 'news';
            $page_sub = 'index';
            return view('admin.news.edit', compact('news', 'titlePage', 'page_menu', 'page_sub'));
        }else{
            return view('admin.error');
        }
    }

    public function update ($id, Request $request)
    {
        try{
            $news = NewsModel::find($id);
            if (empty($news)){
                return back()->with(['error'=> 'Tin tức không tồn tại']);
            }
            if ($request->hasFile('file')){
                $file = $request->file('file');
                $part = 'upload/banner/img/';
                $file_name = $part.Str::random(40). '.'. $file->getClientOriginalExtension();
                $request->file('file')->move($part, $file_name);
                unlink($news->image);
                $news->image = $file_name;
            }
            if ($request->get('display') == 'on'){
                $display = 1;
            }else{
                $display = 0;
            }
            if ($request->get('is_featured') == 'on'){
                $is_featured = 1;
            }else{
                $is_featured = 0;
            }
            $news->title = $request->get('title');
            $news->slug = Str::slug($request->get('title'));
            $news->content = $request->get('content');
            $news->type = $request->get('type');
            $news->index = $request->get('index');
            $news->is_featured = $is_featured;
            $news->display = $display;
            $news->save();
            return \redirect()->route('admin.news.index')->with(['success' => 'Sửa tin tức thành công']);
        }catch (\Exception $exception){
            return back()->with(['error' => $exception->getMessage()]);
        }
    }
}
