<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Validator;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'description',
        'price',
        'category_id',
        'stock_quantity',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
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
                'product_name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'category_id' => 'required|exists:categories,id',
                'stock_quantity' => 'required|numeric',
            ];
        } elseif ($process == 'update') {
            return [
                'product_name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'category_id' => 'required|exists:categories,id',
                'stock_quantity' => 'required|numeric',
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
            'product_name' => 'Nama Produk',
            'description' => 'Deskripsi Produk',
            'price' => 'Harga',
            'category_id' => 'ID Kategori',
            'stock_quantity' => 'Jumlah Stok',
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

        $validator->addReplacer('numeric', function ($message, $attribute, $rule, $parameters) use ($customAttributes) {
            return str_replace(':attribute', $customAttributes[$attribute], ':attribute harus berupa angka.');
        });

        $validator->addReplacer('exists', function ($message, $attribute, $rule, $parameters) use ($customAttributes) {
            return str_replace(':attribute', $customAttributes[$attribute], ':attribute tidak valid.');
        });
    }
}