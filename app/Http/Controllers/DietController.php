<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Companion;
use App\Models\Diet;
use App\Models\SensorPatient;
use App\Models\NormalPatient;
use Termwind\Components\Dd;
use App\Models\HasFactory;
use App\Traits\GeneralTrait;
use Tymon\JWTAuth\Facades\JWTAuth;


class DietController extends Controller
{
    use GeneralTrait;

    public function getAllMeals()
    {
        $meals = Diet::get();
            return $this->returnData(key:'meals', value:$meals, msg:'Meals fetched successfully!');
    }

    public function getSearchedMeals(Request $request)
    {
        $key_word=$request->key_word;
        $searched_meals=Diet::where('name', 'LIKE', '%'.$key_word.'%')
                            ->get();
        $array_size= sizeof($searched_meals);
        
        if ($array_size==0)
        {
            return $this->returnError(errNum:'',msg:"No result, sorry");
        }
        else 
        {
            return $this->returnData(key:'searched_meals', value:$searched_meals, msg:'Meals fetched successfully!');
        }
    }
}
