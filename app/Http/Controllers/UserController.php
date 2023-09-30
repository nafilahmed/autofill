<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('user_role_id',2)->get();
        return view('user')->with("users",$users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $status = 200;

        try{

            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => 'required|max:20',
                'email' => 'required|unique:users|max:50',
            ]);

            if ($validator->fails()) {
                $status = 500;
                $message = $validator->errors();
            }else{


                $data['user_role_id'] = 2;
                $data['password'] = Hash::make('login123');
                $user = User::create($data);
                $message = 'User created successfully';
            }
            
        }catch (\Illuminate\Database\QueryException $qe) {
            $status = 500;
            $message = $qe->getMessage();
        }
        catch(\Exception $ex) {
            $status = 500;            
            $message = $ex->getMessage();
        }
        catch (\Throwable $t) {
            $status = 500;            
            $message = $t->getMessage();
        }

        return response(['status_code' => $status, 'message' => $message]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response(['status_code' => 200,'data' => $user->toArray()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $status = 200;

        try{

            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => 'required|max:20',
                'email' => 'required|max:50',

            ]);

            if($validator->fails()){

                $status = 500;
                $message = $validator->errors();

            }else{

                $user->update($data);
                $message = 'User updated successfully';
               
            }


        }catch (\Illuminate\Database\QueryException $qe) {
            $status = 500;
            $message = $qe->getMessage();
        }
        catch(\Exception $ex) {
            $status = 500;            
            $message = $ex->getMessage();
        }
        catch (\Throwable $t) {
            $status = 500;            
            $message = $t->getMessage();
        }

        return response(['status_code' => $status, 'message' => $message]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
