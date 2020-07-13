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

    public function testItemDates()
    {
        $rss = simplexml_load_file('https://medium.com/feed/cledilson-nascimento');
        $item = $rss->channel->item[0];
        $item->pubDate = 'Sat, 06 Jun 2020 00:23:14 GMT';
        $item->children('http://www.w3.org/2005/Atom')->updated = '2020-07-08T00:23:14.269Z';

        $itemObject = new ItemItem($item);

        $this->assertIsString($itemObject->getDate());
        $this->assertEquals('2020-06-06 00:23:14', $itemObject->getDate());
        $this->assertEquals('2020-06-06', $itemObject->getDate('2020-06-06'));
        $this->assertIsString($itemObject->getUpdated());
        $this->assertEquals('2020-07-08 00:23:14', $itemObject->getUpdated());
    }
    public function testItemContent()
    {
        $rss = simplexml_load_file('https://medium.com/feed/cledilson-nascimento');
        $item = $rss->channel->item[0];
        $item->pubDate = 'Sat, 06 Jun 2020 00:23:14 GMT';
        $item->children('http://www.w3.org/2005/Atom')->updated = '2020-07-08T00:23:14.269Z';
        $item->children('http://purl.org/rss/1.0/modules/content/')
            ->encoded = '<figure><img alt="" src="https://cdn-images-1.medium.com/max/1024/1*LeOnZbo_1P-WGy3BDW_rDw.png" />
            <figcaption>Imagem de <a href="https://pixabay.com/pt/users/Boskampi-3788146/?utm_source=link-attribution&amp;
            utm_medium=referral&amp;utm_campaign=image&amp;utm_content=1873854">Boskampi</a> por 
            <a href="https://pixabay.com/pt/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;
            utm_content=1873854">Pixabay</a></figcaption></figure><p>Muito se tem discutido sobre a melhor linguagem de programação. </p><p>Mas, o fato é que dizer qual é a melhor, não é uma tarefa fácil, pois, depende de, no mínimo, alguns pontos a serem observados.</p>';
            $contentText = 'Muito se tem discutido sobre a melhor linguagem de programação. Mas, o fato é que dizer qual é a melhor, não é uma tarefa fácil, pois, depende de, no mínimo, alguns pontos a serem observados.';
            $contentTextLenght = 'Muito se tem discutido sobre a melhor linguagem de programação.'; // 63 chars



        $itemObject = new ItemItem($item);

        $this->assertNotNull($itemObject->getContent());
        $this->assertTrue(is_string($itemObject->getContent()));
        $this->assertEquals($contentText, $itemObject->getContentText());
        $this->assertEquals($contentTextLenght, $itemObject->getContentText(63));//63
        $this->assertNotEquals($contentTextLenght, $itemObject->getContentText(60));
        $this->assertEquals($contentTextLenght, $itemObject->getContentText(58, 10));
    }


    public function testItemCategories()
    {
        $rss = simplexml_load_file('https://medium.com/feed/the-story');
        $item = $rss->channel->item[0];

        $itemObject = new ItemItem($item);
        $this->assertTrue(count($itemObject->getCategories()) > 0);
        foreach ($itemObject->getCategories() as $value) {
            $this->assertIsString($value);
        }
    }
}
