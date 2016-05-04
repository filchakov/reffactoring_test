<?php

require_once('CustomerInterface.php');

class OrderAdapter implements ICustomer
{

    /**
     * @var Order
     */
    protected $order;

    /**
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->setOrder($order);
    }

    /**
     * @param Order $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }


    public function getEmail()
    {
        return $this->order->customerEmail;
    }

    public function getCreatedAt()
    {
        return $this->order->createdAt;
    }
}