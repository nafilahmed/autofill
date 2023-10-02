<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Website;
use App\Models\WebsiteSelection;
use Illuminate\Http\Request;
use Validator;
use Hash;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->user_role_id == 2){
            $users = User::where(['user_role_id' => 3,'created_by' =>  Auth::user()->id])->get();
            $websites = Website::where('created_by',Auth::user()->id)->get();
        }else{
            $users = User::where('user_role_id',3)->get();
            $websites = Website::get();
        }
        return view('client')->with(["users"=>$users , 'websites'=>$websites]);
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
                'website' => 'required'
            ]);

            if ($validator->fails()) {
                $status = 500;
                $message = $validator->errors();
            }else{

                $user = new User;
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->user_role_id = 3;
                $user->password =  Hash::make($data['password'] ?? 'login123');
                $user->created_by = Auth::user()->id ;
                $user->save();

                WebsiteSelection::where('user_id',$user->id)->delete();
                $websites = $data['website'];
                foreach($websites as $website){
                    $WebsiteSelections = new WebsiteSelection();
                    $WebsiteSelections->user_id = $user->id;
                    $WebsiteSelections->website_id = $website;
                    $WebsiteSelections->save();
                }
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
    public function show($id)
    {
        $user = User::select('id','name','email')->where('id', $id)->first()->toArray();
        $website = WebsiteSelection::select('user_id','website_id')->where('user_id',$id)->get()->toArray();
        $data = array_merge(['user' => $user, 'website'=>$website]);
        return response(['status_code' => 200,'data' => $data]);
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
    public function update(Request $request,$id)
    {
        $status = 200;
        try{

            $data = $request->all();
            
            $validator = Validator::make($data, [
                'name' => 'required|max:50',
                'email' => 'required|max:50',
                'website' => 'required'
                // 'password' => 'required|max:50',

            ]);

            if($validator->fails()){
                $status = 500;
                $message = $validator->errors();

            }else{
                
                $update_user = User::where('id', $id)->first();
                $update_user->name = $data['name'];
                $update_user->email = $data['email'];
                $update_user->created_by = Auth::user()->id;
                if (!empty($data['password'])) {
                    $update_user->password = Hash::make($data['password']);
                }
                $update_user->save();
                
                WebsiteSelection::where('user_id',$update_user->id)->delete();
                $websites = $data['website'];
                foreach($websites as $website){
                    $WebsiteSelections = new WebsiteSelection();
                    $WebsiteSelections->user_id = $update_user->id;
                    $WebsiteSelections->website_id = $website;
                    $WebsiteSelections->save();
                }
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
