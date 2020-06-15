<?php

namespace SimpleMediumRSS\Item;

use Countable;
use Iterator;
use SimpleXMLElement;

class ItemSet implements Iterator, Countable
{

    private $position;
    /** @var SimpleXMLElement */
    private $itens;

    /**
     * @param SimpleXMLElement $itens
     */
    public function __construct($itens)
    {
        $this->itens = $itens;
        $this->position = 0;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function current(): Item
    {
        $item = new Item($this->itens[$this->position]);
        return $item;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function valid(): bool
    {
        return isset($this->itens[$this->position]);
    }

    public function count(): int
    {
        return count($this->itens);
    }
}
