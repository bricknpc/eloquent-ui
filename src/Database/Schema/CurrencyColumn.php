<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Database\Schema;

use Illuminate\Database\Schema\Blueprint;

class CurrencyColumn
{
    public const string CURRENCY_COLUMN_SUFFIX = '_currency';

    private Blueprint $blueprint;
    private string $name;
    private bool $nullable    = false;
    private bool $hasIndex    = false;
    private bool $doubleIndex = false;
    private bool $created     = false;

    public function __construct(Blueprint $blueprint, string $name)
    {
        $this->blueprint = $blueprint;
        $this->name      = $name;
    }

    public function __destruct()
    {
        $this->create();
    }

    public function nullable(bool $value = true): self
    {
        $this->nullable = $value;

        return $this;
    }

    public function index(bool $double = false): self
    {
        $this->hasIndex    = true;
        $this->doubleIndex = $double;

        return $this;
    }

    public function create(): void
    {
        if ($this->created) {
            return;
        }

        // Create the bigInteger column for amount in cents
        $amountColumn = $this->blueprint->bigInteger($this->name);
        if ($this->nullable) {
            $amountColumn->nullable();
        }

        // Create the string column for currency code
        $this->blueprint->string($this->name . self::CURRENCY_COLUMN_SUFFIX)->nullable();

        // Add indexes if requested
        if ($this->hasIndex) {
            if ($this->doubleIndex) {
                // Composite index on both columns
                $this->blueprint->index([$this->name, $this->name . self::CURRENCY_COLUMN_SUFFIX]);
            } else {
                // Index only on the amount column
                $this->blueprint->index($this->name);
            }
        }

        $this->created = true;
    }
}
