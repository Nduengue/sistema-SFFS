<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Product = Product::with(['course'])->get();

        // Retornar apenas os campos desejados
        $result = $Product->map(function ($values) {
            return [
                'id'           => $values->id,
                'titile'   => $values->title,
                'price'  => $values->price,  
                'tax'          => $values->tax,  
                'description'   => $values->description,    
                'course_name'   => $values->course->course_name,
                'created_at'   => $values->created_at,
                'updated_at'   => $values->updated_at,
            ];
        });
       
        return response()->json($result, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Product = Product::with(['course'])->findOrFail($id);
        return response()->json([
            'id'             => $Product->id,
            'titile'         => $Product->title,
            'price'          => $Product->price,  
            'tax'          => $Product->tax,  
            'description'    => $Product->description,    
            'course_name'    => $Product->course->course_name,
            'created_at'     => $Product->created_at,
            'updated_at'     => $Product->updated_at,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}
