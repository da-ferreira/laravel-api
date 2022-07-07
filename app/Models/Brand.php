<?php

namespace App\Models;

use App\Models\Model as ModelsModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image'];

    public function rules()
    {
        return [
            // O campo unique vai desconsiderar 'olhar' o campo de id informado (o id atual). É útil para o método update
            'name' => 'required|min:3|unique:brands,name,' . $this->id,
            'image' => 'required|file|mimes:png',
        ];
    }

    public function feedback()
    {
        return [
            'required' => 'The :attribute field is required',
            'image.mimes' => 'The image must be a file of type PNG',
            'name.unique' => 'Brand name already exists',
            'name.min' => 'The name must be at least 3 characters',
        ];
    }

    /**
     * Relacionamento entre modelo e marca. Uma marca possui muitos modelos
     */
    public function models()
    {
        return $this->hasMany(ModelsModel::class);
    }
}
