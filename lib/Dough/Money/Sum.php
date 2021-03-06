<?php

/*
 * This file is part of Dough.
 *
 * (c) Tim Nagel <tim@nagel.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dough\Money;

use Dough\Bank\BankInterface;

/**
 * Represents a sum of multiple monetary objects.
 *
 * @author Tim Nagel <tim@nagel.com.au>
 */
class Sum extends BaseMoney
{
    private $augend;
    private $addend;

    /**
     * Adds an addend to the augend.
     *
     * @param MoneyInterface $augend
     * @param MoneyInterface $addend
     */
    public function __construct(MoneyInterface $augend, MoneyInterface $addend)
    {
        $this->augend = $augend;
        $this->addend = $addend;
    }

    /**
     * Returns the augend of this sum.
     *
     * @return MoneyInterface
     */
    public function getAugend()
    {
        return $this->augend;
    }

    /**
     * Returns to the addend.
     *
     * @return MoneyInterface
     */
    public function getAddend()
    {
        return $this->addend;
    }

    /**
     * Reduces the sum to a single unit of currency.
     *
     * @param \Dough\Bank\BankInterface $bank
     *
     * @return Money
     */
    public function reduce(BankInterface $bank = null)
    {
        if (null === $bank) {
            $bank = static::getBank();
        }

        $amount = $this->augend->reduce($bank)->getAmount() +
                  $this->addend->reduce($bank)->getAmount();

        return new Money($amount);
    }

    /**
     * Multiplies all items of this sum by the multiplier.
     *
     * @param int|float $multiplier
     * @return Sum
     */
    public function times($multiplier)
    {
        return new self($this->augend->times($multiplier), $this->addend->times($multiplier));
    }
}
