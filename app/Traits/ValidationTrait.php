<?php

namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

trait ValidationTrait
{
    protected function dataValidation(array $data, array $validation, array $messageCustom)
    {
        $validator = Validator::make($data, $validation, $messageCustom);
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'message' => 'Check your validation',
                'errors' => $validator->errors()
            ], 422));
        }
    }
}
