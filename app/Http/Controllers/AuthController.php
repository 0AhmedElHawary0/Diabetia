<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Companion;
use App\Models\SensorPatient;
use App\Models\NormalPatient;
use Termwind\Components\Dd;
use App\Models\HasFactory;
use App\Traits\GeneralTrait;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use GeneralTrait;

    public function __construct()
    {
        
    }
    public function register(Request $request)
    {
        $validator =Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|string|unique:companions|unique:normal_patients|unique:sensor_patients',
            'password'=>'required|string|confirmed|min:6',
            'type'=>'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }
        if ($request->type=='companion') {
            $user = Companion::create(array_merge(
                $validator->validated(),
                ['password'=>bcrypt($request->password)]
            ));
        }

        elseif ($request->type=='sensor_patient') {
            $user = SensorPatient::create(array_merge(
                $validator->validated(),
                ['password'=>bcrypt($request->password)]
            ));
        }

        elseif ($request->type=='normal_patient') {
            $user = NormalPatient::create(array_merge(
                $validator->validated(),
                ['password'=>bcrypt($request->password)]
            ));
        }

        $type=$request->type;

        $user->type=$type;

        // return response()->json([
        //     'message'=>'User Successfully registered',
        //     'user'=>$user
        // ],201);
        return $this->returnData(key:'user',value:$user,msg:'User successfully registered');

    }
                                        // ^^^ END OF REG FUNCTION ^^^

    public function login(Request $request){
        $validator =Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required|string|min:6'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }

        $credentials = $request ->only(['email','password']);
        if(($token = Auth::guard('companion-api')->attempt($credentials))== false)
        {
            if(($token = Auth::guard('normal-patient-api')->attempt($credentials))== false)
            {
                $token = Auth::guard('sensor-patient-api')->attempt($credentials);
                $user = Auth::guard('sensor-patient-api')->user();
                if ($token)
                {
                    $user ->token = $token;
                }
            }
            else 
            {
                $token = Auth::guard('normal-patient-api')->attempt($credentials);
                $user = Auth::guard('normal-patient-api')->user();
                $user ->token = $token;
            }
        }
        else
        {
            $token = Auth::guard('companion-api')->attempt($credentials);
            $user = Auth::guard('companion-api')->user();
            $user ->token = $token;
        }

        if(!$token)
        {
            return $this->returnError(errNum:'E001', msg:'Login info not right');
        }
        else
        {
            return $this->returnData(key:'user',value: $user);
        }
        
    }

                                        // ^^^ END OF Login FUNCTION ^^


public function logout(Request $request)
{
    $token= $request ->header(key:'auth-token');
    if ($token) 
    {
        try 
        {
            JWTAuth::setToken($token)->invalidate();
        }
        catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e)
        {
            return $this-> returnError(errNum:'',msg:'Something went wrong');
        }
        return $this -> returnSuccessMessage(msg:'Logged out successfully');
    }
    else 
    {
        return $this-> returnError(errNum:'',msg:'Something went wrong');
    }
}
                                        // ^^^ END OF Logout FUNCTION ^^

public function userData(Request $request)
{

    if ($request->header(key:'type') == 'companion') 
    {
        $id = $request->header(key:'id');
        $user=Companion::find($id);
        if ($user==null) 
        {
            return $this->returnError(errNum:'',msg:'Something went wrong!');
        }
        else {
            return $this->returnData(key:'user',value:$user,msg:'User found successfully');        
        }
    }

    elseif ($request->header(key:'type') == 'sensor_patient') 
    {
        $id = $request->header(key:'id');
        $user=SensorPatient::find($id);
        if ($user==null) 
        {
            return $this->returnError(errNum:'',msg:'Something went wrong!');
        }
        else {
            return $this->returnData(key:'user',value:$user,msg:'User found successfully');        
        }
    }

    elseif ($request->header(key:'type') == 'normal_patient') 
    {
        $id = $request->header(key:'id');
        $user=NormalPatient::find($id);
        if ($user==null) 
        {
            return $this->returnError(errNum:'',msg:'Something went wrong!');
        }
        else {
            return $this->returnData(key:'user',value:$user,msg:'User found successfully');        
        }
    }

    else
    {
        return $this->returnError(errNum:'',msg:'Something went wrong!');
    }
}


                                        // ^^^ END OF USER DATA FUNCTION ^^
}
