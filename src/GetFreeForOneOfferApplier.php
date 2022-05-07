<?php

declare(strict_types=1);

namespace CinemaCheckout;

use Carbon\CarbonInterface;

class GetFreeForOneOfferApplier implements OfferAppliable
{
    public const OFFER_DAY = CarbonInterface::THURSDAY;

    private int $freeProductsQuantityCoefficient = 2;
    private int $discountCoefficient = 1;

    /**
     * @return array<int, int>
     */
    public function apply(ProductInterface $product): array
    {
        $discountedPrices = [$product->getPrice()];

        $discountedPrice = $product->getPrice() - $product->getPrice() * $this->getDiscountCoefficient();

        for ($i = 0; $i < $this->getFreeProductsQuantityCoefficient(); ++$i) {
            $discountedPrices[] = $discountedPrice;
        }

        return $discountedPrices;
    }

    public function getFreeProductsQuantityCoefficient(): int
    {
        return $this->freeProductsQuantityCoefficient;
    }

    public function getDiscountCoefficient(): int
    {
        return $this->discountCoefficient;
    }

    public function satisfiesCondition(ProductInterface $product): bool
    {
        return true;
    }
}
