<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Request;
use Validator;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $websites = Website::all();

        return view('website')->with("websites",$websites);
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
                'url' => 'required|unique:websites|max:20',
            ]);

            if ($validator->fails()) {
                $status = 500;
                $message = $validator->errors();
            }else{
                $website = Website::create($data);
                $message = 'Website created successfully';
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
    public function show(Website $website)
    {
        return response(['status_code' => 200,'data' => $website->toArray()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Website $website)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Website $website)
    {
        $status = 200;

        try{

            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => 'required|max:20',
                'url' => 'required|max:20',

            ]);

            if($validator->fails()){

                $status = 500;
                $message = $validator->errors();

            }else{

                $website->update($data);
                $message = 'Website updated successfully';
               
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
    public function destroy(Website $website)
    {
        //
    }
}
