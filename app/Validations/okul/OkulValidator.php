<?php

namespace App\Validations\okul;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait OkulValidator
{
    public function rules(): array
    {
        return [
            'okul_ad' => 'required|string|max:255',
            'ilce_id' => 'required|exists:ilce,id',
            'il_id'   => 'required|exists:il,id',
        ];
    }

    public function messages(): array
    {
        return [
            'okul_ad' => 'Lütfen geçerli bir okul ismi giriniz.',
            'ilce_id' => 'Lütfen geçerli bir ilçe seçiniz.',
            'il_id'   => 'Lütfen geçerli bir il seçiniz.',
        ];
    }

    /**
     * @throws ValidationException
     */
    public function validations(): void
    {
        $validator = Validator::make(request()->all(), $this->rules(), $this->messages());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
