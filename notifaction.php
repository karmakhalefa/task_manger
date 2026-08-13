<?php

class Product
{
    public function __construct(
        private string $name,
        private float $price,
        private int $stock
    ) {}

    public function reduceStock(int $quantity): void
    {
        if ($quantity > $this->stock) {
            throw new InsufficientStockException();
        }
        $this->stock -= $quantity;
    }
}