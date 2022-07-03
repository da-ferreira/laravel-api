<?php

namespace App\Models;

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
            'image' => 'required',
        ];
    }

    public function feedback()
    {
        return [
            'required' => 'The :attribute field is required',
            'name.unique' => 'Brand name already exists',
            'name.min' => 'The name must be at least 3 characters',
        ];
    }
}
