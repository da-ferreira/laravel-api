<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Repositories\CarRepository;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function __construct(Car $car)
    {
        $this->car = $car;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function index(Request $request)
    {
        $carRepository = new CarRepository($this->car);

        if ($request->has('model_attributes')) {
            $model_attributes = 'model:id,' . $request->get('model_attributes');
            $carRepository->selectAttributesRelatedRecords($model_attributes);
        } else {
            $carRepository->selectAttributesRelatedRecords('model');
        }

        if ($request->has('filter')) {
            $carRepository->filter($request->get('filter'));
        }

        if ($request->has('attributes')) {
            $carRepository->selectAttributes($request->get('attributes'));
        }

        return response()->json($carRepository->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $request->validate($this->car->rules());

        $car = $this->car->create($request->all());

        return response()->json([
                'message' => 'Car added',
                'data' => $car,
            ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show(int $id)
    {
        $car = $this->car->with('model')->find($id);

        if ($car === null) {
            return response()->json([
                'message' => "Cannot find car with id {$id}"
                ], 404);
        }

        return response()->json($car, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, int $id)
    {
        $car = $this->car->find($id);

        if ($car === null) {
            return response()->json([
                'message' => "Cannot find car with id {$id}"
            ], 404);
        }

        if ($request->method() === 'PATCH') {
            $dynamicRules = [];

            foreach ($car->rules() as $input => $rule) {
                if (array_key_exists($input, $request->all())) {
                    $dynamicRules[$input] = $rule;
                }
            }

            $request->validate($dynamicRules);
        } else {
            $request->validate($car->rules());
        }

        $car->fill($request->all());

        $car->save();

        return response()->json($car, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy(int $id)
    {
        $car = $this->car->find($id);

        if ($car === null) {
            return response()->json([
                'message' => "Cannot find car with id {$id}"
            ], 404);
        }

        $car->delete();

        return response()->json([
            'message' => 'The car has been successfully removed',
        ], 200);
    }
}
