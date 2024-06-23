<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name', 'parent_id', 'description', 'image', 'status', 'slug'
    ];

    public static function rules($id = 0)
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('categories', 'name')->ignore($id),
                function($attribute, $value, $fail) {
                    if (strtolower($value) == 'laravel') {
                        $fail('This name is forbidden');
                    }
                }
            ],
            'parent_id' => [
                'nullable',
                'int',
                'exists:categories,id'
            ],
            'image' => [
                'image',
                'max:1048576',
            ],
            'status' => 'required|in:active,archived'
        ];
    }

}
