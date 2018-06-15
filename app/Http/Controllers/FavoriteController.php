<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function store(Request $request, $id)
    {
        \Auth::user()->favorite($id);
        return redirect()->back();
      //var_dump($id);
    //var_dump(\Auth::user()->id);
    }

    public function destroy($id)
    {
        \Auth::user()->unfavorite($id);
        return redirect()->back();
    }
}