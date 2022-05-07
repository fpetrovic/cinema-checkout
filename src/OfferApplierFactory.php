<?php

declare(strict_types=1);

namespace CinemaCheckout;

use Carbon\Carbon;

class OfferApplierFactory
{
    public function getOfferApplier(): ?OfferAppliable
    {
        $weekDay = Carbon::now()->dayOfWeek;

        if ($weekDay === GetFreeForOneOfferApplier::OFFER_DAY) {
            return $this->getFreeForOneOfferApplier();
        }

        return null;
    }

    protected function getFreeForOneOfferApplier(): OfferAppliable
    {
        return new GetFreeForOneOfferApplier();
    }
}
