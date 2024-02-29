<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getAll()
    {
        return response()->json(Product::all()->load('productType'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'product_type_id' => 'required|exists:product_types,id',
        ]);

        Product::create($request->all());

        return response()->json([
            'message' => 'Producto creado exitosamente',
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'product_type_id' => 'required|exists:product_types,id',
        ]);

        // Update product by id
        $product = Product::where('id', $product->id)->first();

        // Validate if exists
        if (!$product) {
            return response()->json([
                'message' => 'Producto no encontrado'
            ], 404);
        }

        // Update product by id
        $product->update($request->all());

        return response()->json([
            'message' => 'Producto actualizado exitosamente',
            'product' => $product,
        ]);
    }

    public function delete(Product $product)
    {
        $product = Product::where('id', $product->id)->first();

        // Validate if exists
        if (!$product) {
            return response()->json([
                'message' => 'Producto no encontrado'
            ], 404);
        }

        // Delete product by id
        $product->delete();

        return response()->json([
            'message' => 'Producto eliminado exitosamente',
        ]);
    }
}
