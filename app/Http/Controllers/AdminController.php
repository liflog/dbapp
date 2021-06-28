<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $role_id = Auth::user()->roles->first()->id;
        $menus= DB::table('menus')->where('role_id',$role_id)->get();
        return view('admin.home',compact('menus'));
    }
    public function dbSettings()
    {
        $collection = DB::table('database_settings')->get();
        return view('admin.db_settings',compact('collection'));
    }
    public function editDbset($id)
    {
        $item = DB::table('database_settings')->where('id',$id)->first();
        return view('admin.edit_db_set',compact('item'));
    }
}
