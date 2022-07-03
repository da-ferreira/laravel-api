<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->brand->all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $request->validate(
            $this->brand->rules(),
            $this->brand->feedback()
        );

        $brand = $this->brand->create($request->all());

        return response()->json([
                'message' => 'Brand added',
                'data' => $brand,
            ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show(int $id)
    {
        $brand = $this->brand->find($id);

        if ($brand === null) {
            return response()->json([
                'message' => "Cannot find brand with id {$id}"
                ], 404);
        }

        return response()->json($brand, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, int $id)
    {
        $brand = $this->brand->find($id);

        if ($brand === null) {
            return response()->json([
                'message' => "Cannot find brand with id {$id}"
            ], 404);
        }

        if ($request->method() === 'PATCH') {
            $dynamicRules = [];

            foreach ($brand->rules() as $input => $rule) {
                // Coleta apenas as regras aplicáveis aos parâmetros parciais da requisição
                if (array_key_exists($input, $request->all())) {
                    $dynamicRules[$input] = $rule;
                }
            }

            $request->validate($dynamicRules, $brand->feedback());
        } else {
            $request->validate($brand->rules(), $brand->feedback());
        }

        $brand->update($request->all());
        return response()->json($brand, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy(int $id)
    {
        $brand = $this->brand->find($id);

        if ($brand === null) {
            return response()->json([
                'message' => "Cannot find brand with id {$id}"
            ], 404);
        }

        $brand->delete();

        return response()->json([
            'message' => 'The brand has been successfully removed',
        ], 200);
    }
}
