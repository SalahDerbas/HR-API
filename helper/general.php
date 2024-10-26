<?php
use App\Http\Response\ApiResponse;

use App\Models\User;






function getStatusText($responseCode){
    $statusTexts = [
        Model_Not_Found_CODE                  => trans('api_response.Model_Not_Found_CODE'),
        PRIVATE_KEY_CODE                      => trans('api_response.PRIVATE_KEY_CODE'),
        INCCORECT_DATA_ERROR_CODE             => trans('api_response.INCCORECT_DATA_ERROR_CODE'),
        LOGIN_SUCCESS_CODE                    => trans('api_response.LOGIN_SUCCESS_CODE'),
        MESSAGE_NOT_FOUND_CODE                => trans('api_response.MESSAGE_NOT_FOUND_CODE'),
        MESSAGE_CODE_ERROR_CODE               => trans('api_response.MESSAGE_CODE_ERROR_CODE'),
        MESSAGE_CODE_SUCCESS_CODE             => trans('api_response.MESSAGE_CODE_SUCCESS_CODE'),
        LOOKUPS_SUCCESS_CODE                  => trans('api_response.LOOKUPS_SUCCESS_CODE'),
    ];

    return ($responseCode == ALL_MESSAGE_CODE) ? $statusTexts: $statusTexts[$responseCode] ?? MESSAGE_NOT_FOUND_CODE;

}


// // =================================================================================================
// //  Start ALL Function for Response Customize

function responseGlobal($data , $statusCode){
    return (new ApiResponse())->responseGlobal($data , $statusCode);
}

function responseSuccess($data , $responseMessage, $responseCode){
    return (new ApiResponse())->responseSuccess($data , $responseMessage , $responseCode);
}

function responseError($message, $statusCode , $code){
    return (new ApiResponse())->responseError($message, $statusCode , $code);
}
function responseValidator($message, $statusCode , $code ,$validate_errors){
    return (new ApiResponse())->responseValidator($message, $statusCode , $code , $validate_errors);
}

function respondUnauthorized($message){
    return (new ApiResponse())->respondUnauthorized($message);
}

function respondForbidden($message){
    return (new ApiResponse())->respondForbidden($message);
}

function respondNotFound($message){
    return (new ApiResponse())->respondNotFound($message);
}

function respondInternalError($message){
    return (new ApiResponse())->respondInternalError($message);
}

function respondUnprocessableEntity($message){
    return (new ApiResponse())->respondUnprocessableEntity($message);
}

function respondMethodAllowed($message){
    return (new ApiResponse())->respondMethodAllowed($message);
}

function respondModelNotFound($message){
    return (new ApiResponse())->respondModelNotFound($message);
}

function respondValidationFailed($message , $validate_errors , $codes){
    return (new ApiResponse())->respondValidationFailed($message , $validate_errors ,$codes);
}

function respondPrivateKey ($message){
    return (new ApiResponse())->respondPrivateKey($message);
}

function respondEmpty ($message , $code)
{
    return (new ApiResponse())->respondEmpty($message , $code);
}
function respondTooManyRequest($message)
{
    return (new ApiResponse())->respondTooManyRequest($message);
}

//  End ALL Function for Response Customize
// =================================================================================================



if (!function_exists('UploadPhotoUser')) {
    function UploadPhotoUser($file , $type)
    {
        if($type == 'update')  {
            $file_name = time().$file->getClientOriginalName();
            $file->move('Profile/' , $file_name);
            $Image = env('APP_URL').'/Profile/'.$file_name;
            return $Image;
        }
        $file_name = time().$file->getClientOriginalName();
        $file->move('Profile/' , $file_name);
        $Image = env('APP_URL').'/Profile/'.$file_name;
        return $Image;
    }
}


if (!function_exists('getUserWithRelations')) {
    function getUserWithRelations($email)
    {
        return User::where(['email'  => $email])->with([
                    'getCountry' ,
                    'getGender' ,
                    'getReigon' ,
                    'getMaterialStatus' ,
                    'getWorkType' ,
                    'getContractType' ,
                    'getStatusUser'
        ])->first();
    }
}


