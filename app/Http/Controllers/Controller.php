<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="Example App Local API",
 *     version="1.0 beta",
 *     @OA\Contact(email="info@ea.ru")
 * )
 * @OA\Server(
 *     url="http://localhost/api/v1"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
