<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        if (!$this->id) {
            $rules['email'] = 'required|string|unique:users,email';
        } else {
            $rules['email'] = 'required|string';
        }
        return [
            'username' => 'string|max:255|unique:users,username',
            'password' => 'string|min:8',
            'name' => 'required|string',
            'phone_number' => 'required|string|numeric',
            'avatar' => 'required',
            'email' => 'required|string|unique:users,email',
            'position_id' => 'required|exists:positions,id',
        ];
    }
    public function messages()
    {
        return[
            'username.unique' => 'Tên đăng nhập đã tồn tại',
            'password.min' => 'Mật khẩu phải từ 8 kí tự trở lên',
            'name.required' => 'Họ và tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.unique' => 'Email đã tồn tại',
            'phone_number.numeric' => 'Số điện thoại phải đúng kí tự',
            'phone_number.required' => 'Số điện thoại không được để trống',
            'avatar.required' => 'Ảnh đại diện không được để trống',
            'position_id.required' => 'Chức vụ tài khoản không được để trống',
        ];
    }
}
