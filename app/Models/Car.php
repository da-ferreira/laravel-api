<?php

namespace App\Models;

use App\Models\Model as ModelsModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_id',
        'license_plate',
        'available',
        'km',
    ];

    public function rules()
    {
        return [
            'model_id' => 'exists:models,id',
            'license_plate' => 'required',
            'available' => 'required',
            'km' => 'required',
        ];
    }

    public function feedback()
    {
        return [
            //
        ];
    }

    /** Um carro pertence a um modelo */
    public function model()
    {
        return $this->belongsTo(ModelsModel::class);
    }
}
