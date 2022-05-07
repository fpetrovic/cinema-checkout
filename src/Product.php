<?php

declare(strict_types=1);

namespace CinemaCheckout;

abstract class Product implements ProductInterface
{
    protected string $name;

    /**
     * Price in pennies.
     */
    protected int $price;
    protected string $type;

    /**
     * @var array<int, string>
     */
    protected array $addOnParentProductTypes = [];

    public function __construct(string $name, int $price)
    {
        $this->name = $name;
        $this->price = $price;

        $this->setType();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array<int, string>
     */
    public function getAddOnParentProductTypes(): array
    {
        return $this->addOnParentProductTypes;
    }

    public function isSubProduct(): bool
    {
        return !empty($this->getAddOnParentProductTypes());
    }

    abstract protected function setType(): void;
}
