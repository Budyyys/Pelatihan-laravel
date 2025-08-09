<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="Layanan Ruangan API",
 *     version="1.0.0",
 *     description="API untuk manajemen ruangan dalam sistem booking",
 *     @OA\Contact(
 *         email="admin@layananruangan.com"
 *     ),
 *     @OA\License(
 *         name="MIT License",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 * @OA\Server(
 *     url="http://localhost:8081",
 *     description="Local Development Server"
 * )
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
abstract class Controller
{
    //
}
