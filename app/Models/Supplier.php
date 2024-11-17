<?php

namespace App\Models;

use Illuminate\Validation\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'Supplier_Name',
        'Supplier_Contact',
        'Address',
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
                'Supplier_Name' => 'required|string|max:225',
                'Supplier_Contact' => 'required|string',
                'Address' => 'required|string',
            ];
        } elseif ($process == 'update') {
            return [
                'Supplier_Name' => 'required|string|max:225',
                'Supplier_Contact' => 'required|string',
                'Address' => 'required|string',
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
            'Supplier_Name' => 'Nama Supplier',
            'Supplier_Contact' => 'Kontak Supplier',
            'Address' => 'Alamat',
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
