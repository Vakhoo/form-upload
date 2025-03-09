<?php

namespace App\Http\Requests\File;

use Illuminate\Foundation\Http\FormRequest;

class StoreFileRequest extends FormRequest
{

    public function rules()
    {
        return [
            'file' => 'required|file|mimes:pdf,docx|max:10240'
        ];
    }

    public function messages()
    {
        return trans('file.validation');
    }
}
