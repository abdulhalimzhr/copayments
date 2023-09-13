<?php

namespace App\DTO;

class SimulateDepositDTO extends AbstractDTO
{
    /**
     * @var string
     */
    private $order_id;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $timestamp;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->amount    = $data['amount'];
        $this->order_id  = $data['order_id'];
        $this->timestamp = $data['timestamp'];
    }

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->order_id;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getTimeStamp(): string
    {
        return $this->timestamp;
    }
}
