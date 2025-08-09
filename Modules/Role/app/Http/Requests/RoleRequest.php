<?php

namespace Modules\Role\Http\Requests;

use Illuminate\Http\Response;
use App\Traits\ApiResponseFormatTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RoleRequest extends FormRequest
{
        use ApiResponseFormatTrait;

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $requetMethod = $this->getMethod();
        $rules = [];

        if ($requetMethod === 'POST') {
            $rules = [
                'name' => 'required|string|max:255|unique:roles,name',
                'guard_name' => 'string|max:255',
            ];
        }
        if ($requetMethod === 'PUT' || $requetMethod === 'PATCH') {
            $rules = [
                'name' => 'required|string|max:255|unique:roles,name,' . $this->route('role'),
                'guard_name' => 'string|max:255',
            ];
        }

        // permissions can be an array of permission names
        if ($this->has('permissions')) {
            $rules['permissions'] = 'array';
            $rules['permissions.*'] = 'exists:permissions,name'; // Assuming permissions are stored in a 'permissions' table
        }

        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($this->validationFailedResponse($validator->errors()->first()), Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
