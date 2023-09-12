<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DTO\SimulateDepositDTO;
use App\Services\Payment\SimulateDeposit as SimulateDepositService;

class SimulateDeposit extends Controller
{
  /**
   * @param Request $request
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
