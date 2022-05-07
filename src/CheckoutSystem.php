<?php

declare(strict_types=1);

namespace CinemaCheckout;

use Exception;

class CheckoutSystem
{
    private Cart $cart;

    public function __construct(?OfferAppliable $offerApplier = null)
    {
        $this->cart = new Cart($offerApplier);
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    /**
     * @throws Exception
     */
    public function addToCart(ProductInterface $product): void
    {
        $this->cart->addToCart($product);
    }

    /**
     * @return array<int, mixed>
     */
    public function completeCheckout(): array
    {
        $receipt = $this->getReceipt();
        $this->clearCart();

        return $receipt;
    }

    public function getTotal(): float
    {
        return $this->cart->getTotalCost();
    }

    public function getSavings(): float
    {
        return $this->cart->getSavings();
    }

    public function clearCart(): void
    {
        $this->cart->clear();
    }

    /**
     * @return array<int, mixed>
     */
    private function getReceipt(): array
    {
        return [$this->getCart()->getCartItems(), $this->getTotal(), $this->getSavings()];
    }
}
