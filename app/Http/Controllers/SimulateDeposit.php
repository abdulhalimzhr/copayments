<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DTO\SimulateDepositDTO;
use App\Services\Payment\SimulateDeposit as SimulateDepositService;

class SimulateDeposit extends Controller
{
  /**
   * Simulate deposit
   * POST /api/v1/simulate/deposit
   * 
   * Body: {
   *  "order_id": "string",
   *  "amount": "numeric",
   *  "timestamp": "date_format:Y-m-d H:i:s"
   * }
   * 
   * Response: {
   *  "status": "boolean",
   *  "message": "string",
   *  "data": {
   *    "order_id": "string",
   *    "amount": "numeric",
   *    "status": "boolean",
   *  }
   * }
   * @param Request $request
   * @param SimulateDepositService $service
   * 
   * @return \Illuminate\Http\JsonResponse
   */
  public function deposit(Request $request, SimulateDepositService $service)
  {
    $validated = $this->validate($request, [
      'order_id'  => 'required|string',
      'amount'    => 'required|numeric|min:1',
      'timestamp' => 'required|date_format:Y-m-d H:i:s'
    ]);

    if (!$validated) {
      return response()->json([
        'status' => false,
        'message' => 'Invalid request'
      ], 400);
    }

    $data = $request->all();
    $dto  = new SimulateDepositDTO($data);

    return response()->json(
      $service->deposit($dto),
      200
    );
  }
}
