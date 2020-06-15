<?php
namespace SimpleMediumRSSTest\Item;

use PHPUnit\Framework\TestCase;
use SimpleMediumRSS\Item\Item as ItemItem;

class ItemTest extends TestCase
{

    public function testItem()
    {
        $rss = simplexml_load_file('https://medium.com/feed/cledilson-nascimento');
        $item = $rss->channel->item[0];

        $itemObject = new ItemItem($item);

        $this->assertNotNull($itemObject->getTitle());
        $this->assertTrue(is_string($itemObject->getTitle()));
        $this->assertNotNull($itemObject->getContent());
        $this->assertTrue(is_string($itemObject->getContent()));
        $this->assertIsString($itemObject->getLink());
        $this->assertIsString($itemObject->getDate());
        $this->assertIsString($itemObject->getUpdated());
    }

    public function testItemCategories()
    {
        $rss = simplexml_load_file('https://medium.com/feed/the-story');
        $item = $rss->channel->item[0];

        $itemObject = new ItemItem($item);
        $this->assertTrue(count($itemObject->getCategories()) > 0);
        foreach($itemObject->getCategories() as $value){
            $this->assertIsString($value);
        }
    }
}