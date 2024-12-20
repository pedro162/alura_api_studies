<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\IndexSerieRequest;
use App\Http\Requests\StoreSerieRequest;
use App\Http\Requests\UpdateSerieRequest;
use App\Http\Resources\SerieCollection;
use App\Http\Resources\SerieResource;
use App\Interfaces\SerieRepositoryInterface;
use App\Models\Serie;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class SerieController extends Controller
{

    public function __construct(private SerieRepositoryInterface $serieRepositoryInterface) {}

    /**
     * Display a listing of the resource.
     */
    public function index(IndexSerieRequest $request, Authenticatable $user)
    {
        //dd($request->user());
        //dd($user);
        //dd($user->tokenCan('series:delete'));
        $data = $this->serieRepositoryInterface->index($request->all());
        return ApiResponseClass::sendResponse(SerieResource::collection($data), '', 200);
        //return ApiResponseClass::sendResponse(new SerieCollection($data), '', 200);
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
    public function store(StoreSerieRequest $request)
    {
        $details = [
            'name' => $request->name
        ];
        DB::beginTransaction();
        try {
            $serie = $this->serieRepositoryInterface->store($details);
            DB::commit();
            return ApiResponseClass::sendResponse(new SerieResource($serie), 'Serie created successful', 201);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $serie = $this->serieRepositoryInterface->getById($id);
        return ApiResponseClass::sendResponse(new SerieResource($serie), '', 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Serie $serie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSerieRequest $request, string $id)
    {
        $updateDetails = [
            'name' => $request->name
        ];
        DB::beginTransaction();
        try {
            $serie = $this->serieRepositoryInterface->update($updateDetails, $id);
            DB::commit();
            return ApiResponseClass::sendResponse(null, 'Product updated successfully', 204);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->serieRepositoryInterface->delete($id);
        return ApiResponseClass::sendResponse(null, 'Product deleted successfully', 204);
    }

    public function seasons(Request $request, string $id)
    {
        //return Series::find($id)->seasons;
    }
    public function episodes(Request $request, string $id)
    {
        //return Series::find($id)->episodes;
    }
}
