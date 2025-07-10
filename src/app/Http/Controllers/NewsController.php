<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
class NewsController extends Controller
{
   public function sharePage($id){
    $news = News::findOrFail($id);
    
    // Truyền dữ liệu bài viết tới view
    return view('share', ['news' => $news]);
   }
}
