<?php

declare(strict_types=1);

namespace CinemaCheckout;

class TicketAddOn extends Product
{
    public const REAL3D_PRODUCT_NAME = 'real3D';
    public const IMAX_PRODUCT_NAME = 'iMAX';

    /**
     * @var array<int, string>
     */
    protected array $addOnParentProductTypes = ['ticket'];

    protected function setType(): void
    {
        $this->type = 'ticketAddOn';
    }
}
