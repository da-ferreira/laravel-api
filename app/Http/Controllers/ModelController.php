<?php

namespace App\Http\Controllers;

use App\Models\Model;
use App\Repositories\ModelRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModelController extends Controller
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function index(Request $request)
    {
        $modelRepository = new ModelRepository($this->model);

        if ($request->has('brand_attributes')) {
            $brand_attributes = 'brand:id,' . $request->get('brand_attributes');
            $modelRepository->selectAttributesRelatedRecords($brand_attributes);
        } else {
            $modelRepository->selectAttributesRelatedRecords('brand');
        }

        if ($request->has('filter')) {
            $modelRepository->filter($request->get('filter'));
        }

        if ($request->has('attributes')) {
            $modelRepository->selectAttributes($request->get('attributes'));
        }

        return response()->json($modelRepository->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $request->validate(
            $this->model->rules(),
        );

        $image = $request->file('image');
        $urn_image = $image->store('images/models', 'public');

        $model = $this->model->create([
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'image' => $urn_image,
            'number_doors' => $request->number_doors,
            'places' => $request->places,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs,
        ]);

        return response()->json([
                'message' => 'Model added',
                'data' => $model,
            ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show(int $id)
    {
        $model = $this->model->with('brand')->find($id);

        if ($model === null) {
            return response()->json([
                'message' => "Cannot find model with id {$id}"
                ], 404);
        }

        return response()->json($model, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, int $id)
    {
        $model = $this->model->find($id);

        if ($model === null) {
            return response()->json([
                'message' => "Cannot find model with id {$id}"
            ], 404);
        }

        if ($request->method() === 'PATCH') {
            $dynamicRules = [];

            foreach ($model->rules() as $input => $rule) {
                // Coleta apenas as regras aplicáveis aos parâmetros parciais da requisição
                if (array_key_exists($input, $request->all())) {
                    $dynamicRules[$input] = $rule;
                }
            }

            $request->validate($dynamicRules);
        } else {
            $request->validate($model->rules());
        }

        // Remove a imagem antiga do storage caso uma nova imagem seja passada no update
        if ($request->file('image')) {
            Storage::disk('public')->delete($model->image);

            $image = $request->file('image');
            $urn_image = $image->store('images/models', 'public');
        } else {
            $urn_image = $model->image;
        }

        $model->fill($request->all());
        $model->image = $urn_image;

        $model->save();

        return response()->json($model, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy(int $id)
    {
        $model = $this->model->find($id);

        if ($model === null) {
            return response()->json([
                'message' => "Cannot find model with id {$id}"
            ], 404);
        }

        // Remove a imagem do storage e apaga o registro no banco
        Storage::disk('public')->delete($model->image);
        $model->delete();

        return response()->json([
            'message' => 'The model has been successfully removed',
        ], 200);
    }
}
