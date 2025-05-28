<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserRoleUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'role' => 'sometimes|exists:roles,name',
        ];
    }

    public function updateUserRole(): User
    {
        if ($this->user->id == 1) {
            abort(403, __('auth.failed'));
        }
        if ($this->role) {
            $this->user->removeRoles();
            $this->user->addRole($this->role);
            return $this->user->refresh();
        }
        
        $this->user->removeRoles();
        return $this->user->refresh();
    }
}
