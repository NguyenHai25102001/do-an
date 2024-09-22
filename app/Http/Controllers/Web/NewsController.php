<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\NewsModel;
use App\Models\IntroduceModel;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function news($status)
    {
        $banner_news = NewsModel::where('display',1)->where('is_featured',1)->orderBy('index','desc')->limit(6)->get();
        $news = NewsModel::query();
        $news_right_one = NewsModel::query();
        $news_right_two = NewsModel::query();
        $news_right_three = NewsModel::query();
        $news_right_more = null;
        if ($status == 'trang-chu'){
            $news = $news->where('display',1)->orderBy('created_at','desc')->paginate(10);
            $news_right_one = $news_right_one->where('type',2)->where('display',1)->orderBy('index','desc')->limit(5)->get();
            $news_right_two = $news_right_two->where('type',3)->where('display',1)->orderBy('index','desc')->limit(5)->get();
            $news_right_three = $news_right_three->where('type',4)->where('display',1)->orderBy('index','desc')->limit(5)->get();
            $news_right_more = NewsModel::where('type',1)->where('display',1)->orderBy('index','desc')->limit(5)->get();
        }
        if ($status == 'tin-moi'){
            $news = $news->where('type',1)->where('display',1)->orderBy('created_at','desc')->paginate(10);
            $news_right_one = $news_right_one->where('type',2)->where('display',1)->orderBy('index','desc')->limit(5)->get();
            $news_right_two = $news_right_two->where('type',3)->where('display',1)->orderBy('index','desc')->limit(5)->get();
            $news_right_three = $news_right_three->where('type',4)->where('display',1)->orderBy('index','desc')->limit(5)->get();
        }
        if ($status == 'khuyen-mai'){
            $news = $news->where('type',2)->where('display',1)->orderBy('created_at','desc')->paginate(10);
            $news_right_one = $news_right_one->where('type',1)->where('display',1)->orderBy('index','desc')->limit(5)->get();
            $news_right_two = $news_right_two->where('type',3)->where('display',1)->orderBy('index','desc')->limit(5)->get();
            $news_right_three = $news_right_three->where('type',4)->where('display',1)->orderBy('index','desc')->limit(5)->get();
        }
        if ($status == 'meo-hay'){
            $news = $news->where('type',3)->where('display',1)->orderBy('created_at','desc')->paginate(10);
            $news_right_one = $news_right_one->where('type',1)->where('display',1)->orderBy('index','desc')->limit(5)->get();
            $news_right_two = $news_right_two->where('type',2)->where('display',1)->orderBy('index','desc')->limit(5)->get();
            $news_right_three = $news_right_three->where('type',4)->where('display',1)->orderBy('index','desc')->limit(5)->get();
        }
        if ($status == 'tin-tuyen-dung'){
            $news = $news->where('type',4)->where('display',1)->orderBy('created_at','desc')->paginate(10);
            $news_right_one = $news_right_one->where('type',1)->where('display',1)->orderBy('index','desc')->limit(5)->get();
            $news_right_two = $news_right_two->where('type',2)->where('display',1)->orderBy('index','desc')->limit(5)->get();
            $news_right_three = $news_right_three->where('type',3)->where('display',1)->orderBy('index','desc')->limit(5)->get();
        }

        return view('web.news.index', compact( 'banner_news','news','status','news_right_one','news_right_two',
            'news_right_three','news_right_more'));
    }

    public function detailNew($slug)
    {
        $data = NewsModel::where('slug',$slug)->first();
        $data_more = NewsModel::where('type',$data->type)->inRandomOrder()->limit(6)->get();
        return view('web.news.detail-news', compact( 'data','data_more'));
    }

    public function introduce($slug)
    {
        $data = IntroduceModel::where('display',1)->where('slug',$slug)->first();
        return view('web.introduce.index', compact( 'data'));
    }
}
