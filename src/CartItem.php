<?php

declare(strict_types=1);

namespace CinemaCheckout;

class CartItem
{
    private ProductInterface $product;
    private int $quantity = 0;

    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function increaseQuantity(): void
    {
        ++$this->quantity;
    }
}
