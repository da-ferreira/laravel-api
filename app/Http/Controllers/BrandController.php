<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Brand::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $brand = Brand::create($request->all());
        return $brand;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     */
    public function show(Brand $brand)
    {
        return $brand;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     */
    public function update(Request $request, Brand $brand)
    {
        $brand->update($request->all());
        return $brand;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return [
            'message' => 'The brand has been successfully removed',
        ];
    }
}
