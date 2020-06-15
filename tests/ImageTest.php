<?php
namespace SimpleMediumRSSTest;

use PHPUnit\Framework\TestCase;
use SimpleMediumRSS\Image;

class ImageTest extends TestCase
{

    public function testImage()
    {
        $rss = simplexml_load_file('https://medium.com/feed/cledilson-nascimento');
        $image = new Image($rss->channel->image);

        $this->assertNotNull($image->getTitle());
        $this->assertNotNull($image->getLink());
        $this->assertFalse(!filter_var($image->getUrl(), FILTER_VALIDATE_URL));

    }
}