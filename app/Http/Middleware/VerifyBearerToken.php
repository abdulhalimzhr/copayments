<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class VerifyBearerToken
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $request->headers->set("Accept", "application/json");

    $token       = env('THIRD_PARTY_API_TOKEN');
    $bearerToken = trim($request->bearerToken());

    if (
      $bearerToken !== $token ||
      $bearerToken == null ||
      $token == ''
    ) {
      return response()->json([
        'status' => false,
        'message' => 'Unauthorized'
      ], 401);
    }

    return $next($request);
  }
}
