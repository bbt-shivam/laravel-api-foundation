<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


class BaseApiRequest extends FormRequest
{
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
             response()->json([
                'error' => [
                    'status' => 422,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ]
            ], 422)
        );
    }
}
