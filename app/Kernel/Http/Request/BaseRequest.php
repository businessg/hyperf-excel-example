<?php

declare(strict_types=1);

namespace App\Kernel\Http\Request;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Router\Dispatched;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\ValidationException;

class BaseRequest extends FormRequest
{
}

