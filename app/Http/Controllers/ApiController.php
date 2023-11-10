<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Number;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;


class ApiController extends BaseController
{
    protected $num;

    public function savenumber(Request $request)
    {

        $data = $request->only('numbers');
        log::info($data);
        $validator = Validator::make($data, [
            'numbers' => 'integer|digits:5',
        ]);

        //Send failed response if request is not valid
        if($validator -> fails()){
            $message=$validator->errors()->first();
            
            return response()->json([
            'error' => $validator->errors(),
            'code'=>2,
            'message'=> $message], 200);
            
        }
        //Send to database
        $num = Number::create([
            'numbers'=> $request->numbers,
        ]);

        if($num)
        {
            #Send success response
            return response()->json([
                'success' => true,
                'code' =>1,
                'message' => 'Lucky here.',
                'data' => $num
            ], Response::HTTP_OK);
        }


    }
}
