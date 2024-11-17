<?php

namespace App\Models;

use Illuminate\Validation\Validator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Aturan validasi untuk model ini.
     *
     * @return array
     */
    public static function rules($process)
    {
        if ($process == 'insert') {
            return [
                'category_name' => 'required|string|max:225',
            ];
        } elseif ($process == 'update') {
            return [
                'category_name' => 'required|string|max:225',
            ];
        }
    }

    /**
     * Mendaftarkan aturan validasi kustom.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public static function customValidation(Validator $validator)
    {
        $customAttributes = [
            'category_name' => 'Nama Kategori',
        ];
        $validator->addReplacer('required', function ($message, $attribute, $rule, $parameters) use ($customAttributes) {
            return str_replace(':attribute', $customAttributes[$attribute], ':attribute harus diisi.');
        });

        $validator->addReplacer('string', function ($message, $attribute, $rule, $parameters) use ($customAttributes) {
            return str_replace(':attribute', $customAttributes[$attribute], ':attribute harus berupa string.');
        });

        $validator->addReplacer('max', function ($message, $attribute, $rule, $parameters) use ($customAttributes) {
            return str_replace(':attribute', $customAttributes[$attribute], ':attribute tidak boleh lebih dari ' . $parameters[0] . ' karakter.');
        });
    }
}
