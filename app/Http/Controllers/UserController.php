<?php

//  <-- CONTROLLER - THE MIDDLE MAN

namespace App\Http\Controllers;
use App\Models\UserJob;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\User; // <-- The model
use Illuminate\Http\Request; // <-- handling http request in lumen
use App\Traits\ApiResponser; // <-- use to standardized our code for api response


// use DB;  // <---if you're not using lumen eloquent you can use DB component in lumen

class UserController extends Controller
{
    use ApiResponser;
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
// GET

    public function all()
    {
        // eloquent style
        $users = User::all();

        // sql string as parameter (if nag use og DB)
        // $user = DB::connection('mysql')
        // ->select("Select * from tbluser");
        // return response()->json($users, 200); // <-- before
        return $this->successResponse($users);
    }

// GET (ID)
public function show($id)
{ 
    $user = User::findOrFail($id);
    return $this->successResponse($user);

}

// ADD
public function add(Request $request)
{
    
    $rules = [
        'firstname' => 'required|max:150',
        'lastname' => 'required|max:150',
        'jobid' => 'required|numeric|min:1|not_in:0',
    ];
    $this->validate($request, $rules);

    $userjob =UserJob::findOrFail($request->jobid);
    $user = User::create($request->all());

    return $this->successResponse($user, Response::HTTP_CREATED);
}

// UPDATE
public function up(Request $request, $id)
{
    $rules = [
        'firstname' => 'required|max:20',
        'lastname' => 'required|max:20',
        'jobid' => 'required|numeric|min:1|not_in:0',
    ];
    $this->validate($request, $rules);
    $user = User::findOrFail($id);
    $userjob =UserJob::findOrFail($request->jobid);

    $user->fill($request->all());

    $user->save();

    return $user;
}

// DELETE

public function del($id)
{
    $user = User::findOrFail($id);
    $user->delete();
    return $this->successResponse($user);
}

    // Index

public function index()
    {
        $users = User::all();
        return $this->successResponse($users);
    }
}