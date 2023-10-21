<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Website;
use App\Models\WebsiteSelection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Builder;
use Auth;
use Validator;
use Hash;

class URLController extends Controller
{
    public function getCredentials(Request $request): Response
    {

        $site = $request->site;

        $data = User::whereHas('userCredentails', function (Builder $query) use ($site) {
            $query->where('websites.url', $site);
        })->where(['user_role_id' => 3,'created_by' => Auth::user()->id])->get()->toArray();

        return Response(['data' => $data],200);
    }  
}
