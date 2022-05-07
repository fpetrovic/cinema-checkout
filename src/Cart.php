<?php

declare(strict_types=1);

namespace CinemaCheckout;

use Exception;

class Cart
{
    /**
     * @var array<string, CartItem>
     */
    private array $cartItems = [];
    private int $totalCost = 0;
    private int $savings = 0;
    private ?OfferAppliable $offerApplier;

    public function __construct(?OfferAppliable $offerApplier)
    {
        $this->offerApplier = $offerApplier;
    }

    /**
     * @throws Exception
     */
    public function addToCart(ProductInterface $product): void
    {
        $this->validate($product);

        if ($this->getOfferApplier()?->satisfiesCondition($product)) {
            $appliedOfferDiscountedPrices = $this->getOfferApplier()->apply($product);

            for ($i = 0; $i < \count($appliedOfferDiscountedPrices); ++$i) {
                $this->add($product);

                $this->totalCost += $appliedOfferDiscountedPrices[$i];
                $this->savings += $product->getPrice() - $appliedOfferDiscountedPrices[$i];
            }
        } else {
            $this->add($product);
            $this->totalCost += $product->getPrice();
        }
    }

    public function clear(): void
    {
        $this->cartItems = [];
        $this->totalCost = 0;
        $this->savings = 0;
    }

    public function getTotalCost(): float
    {
        return $this->totalCost / 100;
    }

    public function getSavings(): float
    {
        return $this->savings / 100;
    }

    /**
     * @return array<string, CartItem>
     */
    public function getCartItems(): array
    {
        return $this->cartItems;
    }

    public function getCartItem(ProductInterface $product): CartItem|null
    {
        return $this->isProductInCartItems($product) ? $this->cartItems[$product->getName()] : null;
    }

    protected function add(ProductInterface $product): void
    {
        $this->isProductInCartItems($product) ? $this->updateCartItem($product) : $this->createCartItem($product);
    }

    private function isProductInCartItems(ProductInterface $product): bool
    {
        return \array_key_exists($product->getName(), $this->cartItems);
    }

    private function createCartItem(ProductInterface $product): void
    {
        $cartItem = new CartItem($product);

        $cartItem->increaseQuantity();
        $this->setCartItem($cartItem, $product);
    }

    private function updateCartItem(ProductInterface $product): void
    {
        $cartItem = $this->getCartItem($product);

        $cartItem?->increaseQuantity();
        $this->setCartItem($cartItem, $product);
    }

    private function setCartItem(CartItem $cartItem, ProductInterface $product): void
    {
        $this->cartItems[$product->getName()] = $cartItem;
    }

    private function isProductAddable(ProductInterface $product): bool
    {
        if (!$product->isSubProduct()) {
            return true;
        }

        $totalRelatedParentProductQuantity = 0;

        foreach ($this->cartItems as $cartItem) {
            if (\in_array($cartItem->getProduct()->getType(), $product->getAddOnParentProductTypes(), true)) {
                $totalRelatedParentProductQuantity += $cartItem->getQuantity();
            }
        }

        $preAddCartItemQuantity = $this->getCartItem($product)?->getQuantity();
        $totalCartItemQuantity = $preAddCartItemQuantity + 1;

        return ($totalRelatedParentProductQuantity - $totalCartItemQuantity) >= 0;
    }

    /**
     * @throws Exception
     */
    private function validate(ProductInterface $product): void
    {
        if (!$this->isProductAddable($product)) {
            throw new Exception('You will need to add more tickets to buy this product.');
        }
    }

    private function getOfferApplier(): ?OfferAppliable
    {
        return $this->offerApplier;
    }
}
