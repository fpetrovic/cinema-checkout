<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use CinemaCheckout\CheckoutSystem;
use CinemaCheckout\OfferApplierFactory;
use CinemaCheckout\ProductSimpleFactory;

$productSimpleFactory = new ProductSimpleFactory();
$offerApplier = (new OfferApplierFactory())->getOfferApplier();
$checkoutSystem = new CheckoutSystem($offerApplier);

try {
    $standardTicket = $productSimpleFactory->getStandardTicket();
    $concessionTicket = $productSimpleFactory->getConcessionTicket();
    $iMAX = $productSimpleFactory->getIMAX();
    $real3D = $productSimpleFactory->getReal3D();

    $checkoutSystem->addToCart($standardTicket);
    $checkoutSystem->addToCart($standardTicket);
    $checkoutSystem->addToCart($iMAX);
    $checkoutSystem->addToCart($iMAX);
    $checkoutSystem->addToCart($real3D);

    $receipt = $checkoutSystem->completeCheckout();

    print_r($receipt);
} catch (Exception $e) {
    echo $e->getMessage();
}
