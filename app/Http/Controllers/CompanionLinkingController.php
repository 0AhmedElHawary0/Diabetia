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
use App\Models\PatientCompanion;

class CompanionLinkingController extends Controller
{
    use GeneralTrait;

    public function addCompanion (Request $request)
    {
        if (Companion::find($request->header(key:'companion_id'))== null) 
        {
            return $this->returnError(errNum:'',msg:'Please enter the right companion id.');
        }

        elseif (SensorPatient::find($request->header(key:'patient_id'))== null) 
        {
            return $this->returnError(errNum:'',msg:'Something went wrong!');
        }

        else 
        {
            SensorPatient::find($request->header(key:'patient_id'))->companions()->attach([$request->header(key:'companion_id')]);
            return $this->returnSuccessMessage(msg:'Companion added successfully!',errNum:'');
        }
    }

                                                // End of Add Companion Function


    public function deleteCompanion (Request $request)
    {
        if (Companion::find($request->header(key:'companion_id'))== null) 
        {
            return $this->returnError(errNum:'',msg:'Please enter the right companion id.');
        }

        elseif (SensorPatient::find($request->header(key:'patient_id'))== null) 
        {
            return $this->returnError(errNum:'',msg:'Something went wrong!');
        }

        else 
        {
            SensorPatient::find($request->header(key:'patient_id'))->companions()->detach([$request->header(key:'companion_id')]);
            return $this->returnSuccessMessage(msg:'Companion deleted successfully!',errNum:'');
        }
    }

                                                // End of Delete Companion Function

    public function getCompanions(Request $request)
    {
        if (SensorPatient::find($request->header(key:'patient_id'))== null) 
        {
            return $this->returnError(errNum:'',msg:'Something went wrong!');
        }
        else 
        {
            $companions_id = PatientCompanion::select('companion_id')
                                                ->where('patient_id',$request->header(key:'patient_id'))
                                                ->get();
            $companions = Companion::find($companions_id);
            return $this->returnData(key:'companions',value:$companions,msg:'Companions fetched successfully!');
        }
    }
}
