<?php

namespace SimpleMediumRSSTest\Item;

use PHPUnit\Framework\TestCase;
use SimpleMediumRSS\Item\ItemSet;

class ItemSetTest extends TestCase
{

    public function testItemSet()
    {
        $rss = simplexml_load_file('https://medium.com/feed/cledilson-nascimento');
        $itens = $rss->channel->item;
        $itemset = new ItemSet($itens);
        $this->assertTrue($itemset->valid());
        $this->assertTrue(count($itemset) > 1);

        foreach ($itemset as $key => $value) {
            $this->assertIsString($value->getTitle());
            $this->assertIsInt($key);
        }
    }
}
