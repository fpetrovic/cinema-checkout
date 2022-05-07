<?php

/** @noinspection PhpUnnecessaryStaticReferenceInspection */

declare(strict_types=1);

namespace Tests;

use Carbon\Carbon;
use CinemaCheckout\CheckoutSystem;
use CinemaCheckout\GetFreeForOneOfferApplier;
use CinemaCheckout\OfferApplierFactory;
use CinemaCheckout\ProductInterface;
use CinemaCheckout\ProductSimpleFactory;
use CinemaCheckout\Ticket;
use CinemaCheckout\TicketAddOn;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class CheckoutSystemTest extends TestCase
{
    private ?CheckoutSystem $checkoutSystem;
    private ?ProductSimpleFactory $productFactory;
    private ?ProductInterface $standardTicket;
    private ?ProductInterface $concessionTicket;
    private ?ProductInterface $real3D;
    private ?ProductInterface $iMAX;

    protected function setUp(): void
    {
        $this->checkoutSystem = new CheckoutSystem();

        $this->productFactory = new ProductSimpleFactory();
        $this->standardTicket = $this->productFactory->getStandardTicket();
        $this->concessionTicket = $this->productFactory->getConcessionTicket();
        $this->real3D = $this->productFactory->getReal3D();
        $this->iMAX = $this->productFactory->getIMAX();
    }

    protected function tearDown(): void
    {
        $this->checkoutSystem = null;

        $this->productFactory = null;
        $this->standardTicket = null;
        $this->concessionTicket = null;
        $this->real3D = null;
        $this->iMAX = null;
    }

    /**
     * @throws Exception
     */
    public function testCanProductBeAdded(): void
    {
        $this->checkoutSystem->addToCart($this->standardTicket);
        $cartItem = $this->checkoutSystem->getCart()->getCartItems()[Ticket::STANDARD_TICKET_PRODUCT_NAME];

        static::assertSame(
            'standardTicket',
            $cartItem->getProduct()->getName()
        );

        static::assertSame(
            1,
            $cartItem->getQuantity()
        );
    }

    /**
     * @throws Exception
     */
    public function testCanSubProductBeAdded(): void
    {
        $this->checkoutSystem->addToCart($this->standardTicket);
        $this->checkoutSystem->addToCart($this->real3D);
        $cartItem = $this->checkoutSystem->getCart()->getCartItems()[TicketAddOn::REAL3D_PRODUCT_NAME];

        static::assertSame(
            TicketAddOn::REAL3D_PRODUCT_NAME,
            $cartItem->getProduct()->getName()
        );

        static::assertSame(
            1,
            $cartItem->getQuantity()
        );
    }

    public function testExceptionIfNotEnoughParentProducts()
    {
        $this->expectException(Exception::class);

        $this->checkoutSystem->addToCart($this->standardTicket);
        $this->checkoutSystem->addToCart($this->standardTicket);
        $this->checkoutSystem->addToCart($this->concessionTicket);
        $this->checkoutSystem->addToCart($this->iMAX);
        $this->checkoutSystem->addToCart($this->real3D);
        $this->checkoutSystem->addToCart($this->real3D);
        $this->checkoutSystem->addToCart($this->real3D);
        $this->checkoutSystem->addToCart($this->real3D);
    }

    /**
     * @throws Exception
     */
    public function testTotal()
    {
        $this->checkoutSystem->addToCart($this->standardTicket);
        $this->checkoutSystem->addToCart($this->standardTicket);
        $this->checkoutSystem->addToCart($this->concessionTicket);
        $this->checkoutSystem->addToCart($this->real3D);
        $this->checkoutSystem->addToCart($this->real3D);
        $this->checkoutSystem->addToCart($this->real3D);

        static::assertSame(
            ($this->standardTicket->getPrice() * 2 + $this->concessionTicket->getPrice() * 1 + $this->real3D->getPrice() * 3) / 100,
            $this->checkoutSystem->getTotal()
        );
    }

    /**
     * @throws Exception
     */
    public function testThreeForOneSavings()
    {
        $offerDay = Carbon::create(Carbon::now()->startOfWeek()->addDays(GetFreeForOneOfferApplier::OFFER_DAY - 1));
        Carbon::setTestNow($offerDay);

        $offerApplier = (new OfferApplierFactory())->getOfferApplier();
        $this->checkoutSystem = new CheckoutSystem($offerApplier);

        $this->checkoutSystem->addToCart($this->standardTicket);
        $this->checkoutSystem->addToCart($this->standardTicket);
        $this->checkoutSystem->addToCart($this->concessionTicket);
        $this->checkoutSystem->addToCart($this->real3D);
        $this->checkoutSystem->addToCart($this->real3D);
        $this->checkoutSystem->addToCart($this->real3D);

        static::assertSame(
            ($this->standardTicket->getPrice() * 4 + $this->concessionTicket->getPrice() * 2 + $this->real3D->getPrice() * 6) / 100,
            $this->checkoutSystem->getSavings()
        );
    }
}
