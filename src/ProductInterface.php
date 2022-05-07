<?php

namespace CinemaCheckout;

interface ProductInterface extends Purchasable, AddOnInterface
{
    public function getName(): string;

    public function getType(): string;
}
