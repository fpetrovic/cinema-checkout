<?php

namespace CinemaCheckout;

interface AddOnInterface
{
    /**
     * @return array<int, string>
     */
    public function getAddOnParentProductTypes(): array;

    public function isSubProduct(): bool;
}
