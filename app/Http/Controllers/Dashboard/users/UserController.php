<?php

namespace App\Http\Controllers\Dashboard\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = User::orderBy('id','DESC')->paginate(5);
        return view('Dashboard/users.show_users',compact('data'))->with('i', ($request->input('page', 1) - 1) * 5);
    }
    public function create()
    {
    }
    public function store(Request $request)
    {

    }
    public function show($id)
    {
    }
    public function edit($id)
    {
    }
    public function update(Request $request, $id)
    {

    }
    public function destroy(Request $request)
    {

    }
}
