<?php

namespace App\Http\Controllers;

use App\Models\UserJob;
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
        'jobid' => 'required|numeric|min:1|not_in:0',
        ];
        $this->validate($request,$rules);
        // $usersjob = UserJob::findOrFail($request->jobid);
        // UNCOMMENT LAST
        $user = User2::create($request->all());
        return $this->successResponse($user, Response::HTTP_CREATED);
    }

    public function show($id)
    {
        // $user = User2::findOrFail($id);
        $user = User2::where('userid', $id)->firstOrFail();    
        return $this->successResponse($user);    
        // return $this->errorResponse('User ID is not found', Response::HTTP_NOT_FOUND); 
    }

    public function update(Request $request,$id)
    {
        $rules = [
            'username' => 'required|max:20',
            'password' => 'required|max:20',
            'jobid' => 'required|numeric|min:1|not_in:0',
            ];
    
            $this->validate($request, $rules);
            // $user = User::findOrFail($id);  
            $user = User2::where('userid', $id)->firstOrFail(); 
            $user->fill($request->all());
            if ($user->isClean()) {
                return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $user->save();
            return $this->successResponse($user);

        
          
        
    }

    public function delete($id)
    {
        // $user = User2::findOrFail($id);
        $user = User2::where('userid', $id)->firstOrFail();  
        $user->delete();
        return $this->successResponse($user);
        
    }
}
