<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $searchText = $request->input('search');

        $isDate = Carbon::hasFormat($searchText, 'Y-m-d');

        $posts = DB::table('posts');


        if($isDate){
            $posts -> whereDate('created_at', $searchText);
        }else{
            $posts->where('title', 'LIKE', "%{$searchText}%")
            ->orWhere('content', 'LIKE', "%{$searchText}%");
        }
        $posts = $posts->paginate('10');
        return view(  'home', ['posts' =>  $posts]);
    }
}
