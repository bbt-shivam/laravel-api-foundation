<?php

namespace App\Http\Requests\Api\V1\Roles;

use Illuminate\Foundation\Http\FormRequest;

class DeleteRoleRequest extends FormRequest
{

    public function authorize(): bool
    {
        return $this->user()->can('delete', $this->role);
    }

    public function rules(): array
    {
        return [
            //
        ];
    }
}
