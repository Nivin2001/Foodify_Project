<?php
namespace App\Services;

use App\Repositories\OrderRepository;

class OrderService
{
    protected OrderRepository $repo;

    public function __construct(OrderRepository $repo)
    {
        $this->repo = $repo;
    }

    public function createOrder(int $userId)
    {
        return $this->repo->createOrder($userId);
    }
}
?>
