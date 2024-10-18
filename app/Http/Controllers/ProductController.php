<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //https://medium.com/@1415sandalanka/laravel-11-rest-api-crud-with-best-practices-fcc26505e0d2

    private ProductRepositoryInterface $productRepositoryInterface;

    public function __construct(ProductRepositoryInterface $productRepositoryInterface)
    {
        $this->productRepositoryInterface = $productRepositoryInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->productRepositoryInterface->index();
        return ApiResponseClass::sendResponse(ProductResource::collection($data), '', 200);
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
    public function store(StoreProductRequest $request)
    {
        $details = [
            'name' => $request->name,
            'details' => $request->details
        ];

        DB::beginTransaction();
        try {
            $product = $this->productRepositoryInterface->store($details);
            DB::commit();
            return ApiResponseClass::sendResponse(new ProductResource($product), 'Product Create Successful', 201);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = $this->productRepositoryInterface->getById($id);
        return ApiResponseClass::sendResponse(new ProductResource($product), '', 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $updateDetails = [
            'name' => $request->name,
            'details' => $request->details
        ];
        DB::beginTransaction();
        try {
            $product = $this->productRepositoryInterface->update($updateDetails, $id);

            DB::commit();
            return ApiResponseClass::sendResponse('Product Update Successful', '', 201);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
