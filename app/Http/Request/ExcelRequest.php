<?php

declare(strict_types=1);

namespace App\Http\Request;

use App\Kernel\Http\Request\BaseRequest;

class ExcelRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public array $scenes = [
        'export' => ['businessId', 'param'],
        'import' => ['businessId', 'url'],
        'info' => ['businessId'],
        'progress' => ['token'],
        'message' => ['token'],
    ];

    public function rules(): array
    {
        return [
            'businessId' => 'required|string',
            'param' => 'array',
            'token' => 'required|string',
            'url' => 'required|string|url'
        ];
    }

    public function messages(): array
    {
        return [
            'businessId.required' => ':attribute 不能为空',
            'businessId.string' => ':attribute 数据错误',
            'token.required' => ':attribute 不能为空',
            'param.array' => ':attribute 数据错误',
            'url.required' => ':attribute 不能为空',
            'url.string' => ':attribute 数据错误',
            'url.url' => ':attribute 数据错误',
        ];
    }

    public function attributes(): array
    {
        return [
            'businessId' => '业务ID',
            'param' => '参数',
            'token' => 'token',
            'url' => 'url',
        ];
    }
}

