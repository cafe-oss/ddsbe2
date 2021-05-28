<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User2;
use App\Traits\ApiResponser;

class UserController2 extends Controller
{
    use ApiResponser;
    private $request;

    public function __construct(Request $request){
        $this->request = $request;
    }

    public function getUsers(){
        $users = User2::all();
        return response()->json($users, 200);
    }

    public function index()
    {
        $users = User2::all();
        return $this->successResponse($users);
    }

    public function add(Request $request ){
        $rules = [
        'username' => 'required|max:20',
        'password' => 'required|max:20',
        ];
        $this->validate($request,$rules);
        $user = User2::create($request->all());
        return $this->successResponse($user, Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $user = User2::findOrFail($id);
        // $user = User::where('id', $id)->first();    
        return $this->successResponse($user);    
        // return $this->errorResponse('User ID is not found', Response::HTTP_NOT_FOUND); 
    }

    public function update(Request $request,$id)
    {
        $rules = [
        'username' => 'max:20',
        'password' => 'max:20',
        ];

        $this->validate($request, $rules);
        $user = User2::findOrFail($id);  
        if ($user->isClean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user->save();
        return $this->successResponse($user);
    }

    public function delete($id)
    {
        $user = User2::findOrFail($id);
        $user->delete();
        return $this->successResponse($user);
        
    }
}
