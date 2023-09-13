<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AbstractService
{
  /**
   * @var int
   */
  protected const DEPOSIT = 1;

  /**
   * 
   */
  protected const WITHDRAW = 2;

  /**
   * @var string
   */
  protected const POST = 'POST';

  /**
   * @var int
   */
  protected const SUCCESS = 1;

  /**
   * @var int
   */
  protected const FAILED = 0;

  /**
   * @param string $url
   * @param string $method
   * @param array $headers
   * @param array $data
   * 
   * @return string
   */
  public function callApi($url, $method, $headers, $data)
  {
    $response = Http::withHeaders($headers)->$method($url, $data);
    $result  = $response->json();
    Log::info('Call API: ', [
      'url'     => $url,
      'method'  => $method,
      'headers' => $headers,
      'data'    => $data,
      'result'  => $result
    ]);

    return $result;
  }
}
