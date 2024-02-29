<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    public function getAll()
    {
        return response()->json(ProductType::all());
    }

    public function create(Request $request)
    {
        $request->validate([
            'type' => 'required',
        ]);

        ProductType::create($request->all());

        return response()->json([
            'message' => 'Tipo de producto creado exitosamente',
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required',
        ]);

        // Update product type by id
        $product_type = ProductType::where('id', $id)->first();

        // Validate if exists
        if (!$product_type) {
            return response()->json([
                'message' => 'Tipo de producto no encontrado'
            ], 404);
        }

        // Update product type by id
        $product_type->update($request->all());

        return response()->json([
            'message' => 'Tipo de producto actualizado exitosamente',
            'product_type' => $product_type,
        ]);
    }

    public function delete($id)
    {
        // Delete product type by id
        $product_type = ProductType::where('id', $id)->first();

        // Validate if exists
        if (!$product_type) {
            return response()->json([
                'message' => 'Tipo de producto no encontrado'
            ], 404);
        }

        try {
            // Delete product type by id
            $product_type->delete();
        } catch (QueryException $e) {
            // Catch the error if there are still products associated with this product type
            return response()->json([
                'message' => 'No se puede eliminar el tipo de producto ' . $product_type->type . ', existen productos asociados a este tipo.'
            ], 400);
        }

        return response()->json([
            'message' => 'Tipo de producto eliminado exitosamente',
            'product_type' => $product_type
        ]);
    }
}
