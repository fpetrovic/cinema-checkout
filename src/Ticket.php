<?php

declare(strict_types=1);

namespace CinemaCheckout;

class Ticket extends Product
{
    public const STANDARD_TICKET_PRODUCT_NAME = 'standardTicket';
    public const CONCESSION_TICKET_PRODUCT_NAME = 'concessionTicket';

    public string $type;

    protected function setType(): void
    {
        $this->type = 'ticket';
    }
}
