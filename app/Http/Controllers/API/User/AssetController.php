<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\API\User\AssetRequest;
use App\Http\Resources\API\User\AssetResource;
use App\Models\Asset;

class AssetController extends Controller
{
    /**
     * Display a listing of the user's Asset's.
     *
     * @return \Illuminate\Http\Response
     * @author Salah Derbas
     */
    public function index()
    {
        try{
            $data = Asset::where(['user_id' => Auth::id() ])->with(['getAssetType'])->get();

            if($data->isEmpty())
                return responseSuccess('', getStatusText(ASSET_EMPTY_CODE), ASSET_EMPTY_CODE);

            return responseSuccess(AssetResource::collection($data) , getStatusText(ASSETS_SUCCESS_CODE)  , ASSETS_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Store a newly created Asset in storage.
     *
     * @param  \App\Http\Requests\API\User\AssetRequest  $request
     * @return \Illuminate\Http\Response
     * @author Salah Derbas
     */
    public function store(AssetRequest $request)
    {
        try{
            $data                    = $request->all();
            $data['user_id']         = Auth::id();

            if ($request->file('document'))
                $data['document']      = handleFileUpload($request->file('document'), 'store' , 'Asset', NULL);


            Asset::create($data);
            return responseSuccess('' , getStatusText(STORE_ASSET_SUCCESS_CODE)  , STORE_ASSET_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Display the specified vacation.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author Salah Derbas
     */
    public function show($id)
    {
        try{
            $data = Asset::with(['getAssetType'])->findOrFail($id);

            if(is_null($data))
                return responseSuccess('', getStatusText(ASSET_EMPTY_CODE), ASSET_EMPTY_CODE);

            return responseSuccess(new AssetResource($data) , getStatusText(ASSETS_SUCCESS_CODE)  , ASSETS_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Update the specified Asset in storage.
     *
     * @param  \App\Http\Requests\API\User\AssetRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author Salah Derbas
     */
    public function update(AssetRequest $request, $id)
    {
        try{
            $data                    = $request->all();
            $data['user_id']         = Auth::id();
            $Asset                   = Asset::findOrFail($id);

            if ($request->file('document'))
                $data['document']      = handleFileUpload($request->file('document'), 'update' , 'Asset' , $Asset->document );

            $Asset->update($data);
            return responseSuccess('' , getStatusText(UPDATE_ASSET_SUCCESS_CODE)  , UPDATE_ASSET_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Remove the specified Asset from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author Salah Derbas
     */
    public function destroy($id)
    {
        try{
            Asset::findOrFail($id)->delete();
            return responseSuccess('', getStatusText(DELETE_ASSET_CODE), DELETE_ASSET_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

}
