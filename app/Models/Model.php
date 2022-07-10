<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'name',
        'image',
        'number_doors',
        'places',
        'air_bag',
        'abs',
    ];

    public function rules()
    {
        return [
            'brand_id' => 'exists:brands,id',
            'name' => "required|unique:models,name,{$this->id}|min:3",
            'image' => 'required|file|mimes:png,jpeg,jpg',

            // O número de portas e lugares precisa estar no intervalo especificado
            'number_doors' => 'required|integer|digits_between:1,5',
            'places' => 'required|integer|digits_between:1,20',

            // Os valores booleanos aceitos são: true, false, 0, 1, '0', '1'
            'air_bag' => 'required|boolean',
            'abs' => 'required|boolean',
        ];
    }

    public function feedback()
    {
        return [
            //
        ];
    }

    /**
     * Relacionamento entre modelo e marca. Um modelo pertence a uma marca
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
