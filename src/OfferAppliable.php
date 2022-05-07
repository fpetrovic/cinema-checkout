<?php

namespace CinemaCheckout;

interface OfferAppliable
{
    /**
     * @return array<int, int>
     */
    public function apply(ProductInterface $product): array;

    public function satisfiesCondition(ProductInterface $product): bool;
}
