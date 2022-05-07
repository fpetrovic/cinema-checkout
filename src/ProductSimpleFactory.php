<?php

declare(strict_types=1);

namespace CinemaCheckout;

class ProductSimpleFactory
{
    public function getStandardTicket(): ProductInterface
    {
        return new Ticket(Ticket::STANDARD_TICKET_PRODUCT_NAME, 790);
    }

    public function getConcessionTicket(): ProductInterface
    {
        return new Ticket(Ticket::CONCESSION_TICKET_PRODUCT_NAME, 540);
    }

    public function getIMAX(): ProductInterface
    {
        return new TicketAddOn(TicketAddOn::IMAX_PRODUCT_NAME, 150);
    }

    public function getReal3D(): ProductInterface
    {
        return new TicketAddOn(TicketAddOn::REAL3D_PRODUCT_NAME, 90);
    }
}
