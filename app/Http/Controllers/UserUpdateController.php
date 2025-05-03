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
use PhpParser\Node\Stmt\Catch_;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Storage;

class UserUpdateController extends Controller
{
    use GeneralTrait;

public function aboutYourself(Request $request)
{
    if ($request->header(key:'type') == 'sensor_patient') 
    {
        $id = $request->header(key:'id');
        $user=SensorPatient::find($id);
        if ($user==null) 
        {
            return $this->returnError(errNum:'',msg:'Something went wrong!');
        }
        else 
        {
            $user->update([
                'gender'=>$request->gender,
                'weight'=>$request->weight,
                'age'   =>$request->age
            ]);
            $user->save();
            return $this->returnSuccessMessage(msg:"User's info updated successfully!",errNum:'');
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
        else 
        {
            $user->update([
                'gender'=>$request->gender,
                'weight'=>$request->weight,
                'age'   =>$request->age
            ]);
            $user->save();
            return $this->returnSuccessMessage(msg:"User's info updated successfully!",errNum:'');
        }
    }

    else {
        return $this->returnError(errNum:'',msg:'Something went wrong!');
    }
}

                                    // END OF INFO1

public function diabetesType(Request $request)
{
    if ($request->header(key:'type') == 'sensor_patient') 
    {
        $id = $request->header(key:'id');
        $user=SensorPatient::find($id);
        if ($user==null) 
        {
            return $this->returnError(errNum:'',msg:'Something went wrong!');
        }
        else 
        {
            $user->update([
                'diabetes_type'=> $request->diabetes_type
            ]);
            $user->save();
            return $this->returnSuccessMessage(msg:"User's info updated successfully!",errNum:'');
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
        else 
        {
            $user->update([
                'diabetes_type'=> $request->diabetes_type
            ]);
            $user->save();
            return $this->returnSuccessMessage(msg:"User's info updated successfully!",errNum:'');
        }
    }

    else {
        return $this->returnError(errNum:'',msg:'Something went wrong!');
    }
}

                                    // END OF INFO2


public function profileUpdate(Request $request)
{
    if ($request->header(key:'type') == 'sensor_patient') 
    {
        $id = $request->header(key:'id');
        $user=SensorPatient::find($id);
        if ($user==null) 
        {
            return $this->returnError(errNum:'1',msg:'Something went wrong!');
        }
        else 
        {
                $validator = Validator::make($request->all(),[
                    'email'=>'email|unique:companions|unique:normal_patients|unique:sensor_patients,email,'.$user->id,
                    'photo'=>'image'
                ]);
                if ($validator->fails()) 
                {
                    $error = $validator->errors()->all()[0];
                    return response()->json(['status'=>'false', 'message'=>$error, 'data'=>[]],422);
                }
                else 
                {
                    $user->name = $request->name;
                    $user->email = $request->email;
                    $old_photo = $user->photo;
                    if ($request->photo && $request->photo->isValid())
                    {
                        $file_name = time().'.'.$request->photo->extension();
                        $request->photo->move(public_path('images'),$file_name);
                        $path = 'public/images/$file_name';
                        $user->photo = $file_name;
                        $user->photo_url =$path;
                        if ($old_photo != 'user-default.png') 
                        {
                            unlink('D:\\Diabetia2\\public\\images\\'.$old_photo);
                        }
                    }
                }
                $user->update();
                return $this->returnSuccessMessage(msg:'User updated successfully!',errNum:'');
        }
    }

    elseif ($request->header(key:'type') == 'normal_patient') 
    {
        $id = $request->header(key:'id');
        $user=NormalPatient::find($id);
        if ($user==null) 
        {
            return $this->returnError(errNum:'1',msg:'Something went wrong!');
        }
        else 
        {
            $user->name = $request->name;
            $user->email = $request->email;
            $old_photo = $user->photo;
            if ($request->photo && $request->photo->isValid())
            {
                $file_name = time().'.'.$request->photo->extension();
                $request->photo->move(public_path('images'),$file_name);
                $path = 'public/images/$file_name';
                $user->photo = $file_name;
                $user->photo_url =$path;
                if ($old_photo != 'public/images/user-default.png') 
                {
                    unlink('D:\\Diabetia2\\public\\images\\'.$old_photo);
                }
            }
        }
        $user->update();
        return $this->returnSuccessMessage(msg:'User updated successfully!',errNum:'');
    }

    elseif ($request->header(key:'type') == 'companion') 
    {
        $id = $request->header(key:'id');
        $user=Companion::find($id);
        if ($user==null) 
        {
            return $this->returnError(errNum:'1',msg:'Something went wrong!');
        }
        else 
        {
            $user->name = $request->name;
            $user->email = $request->email;
            $old_photo = $user->photo;
            if ($request->photo && $request->photo->isValid())
            {
                $file_name = time().'.'.$request->photo->extension();
                $request->photo->move(public_path('images'),$file_name);
                $path = 'public/images/$file_name';
                $user->photo = $file_name;
                $user->photo_url =$path;
                if ($old_photo != 'public/images/user-default.png') 
                {
                    unlink('D:\\Diabetia2\\public\\images\\'.$old_photo);
                }
            }
        }
        $user->update();
        return $this->returnSuccessMessage(msg:'User updated successfully!',errNum:'');
    }

    else {
        return $this->returnError(errNum:'4',msg:'Something went wrong!');
    }

}

                                    // END OF Update Profile

}
