<?php

namespace SimpleMediumRSSTest;

use PHPUnit\Framework\TestCase;
use SimpleMediumRSS\Exception\InvalidArgumentException;
use SimpleMediumRSS\Exception\SimpleLoadException;
use SimpleMediumRSS\Image;
use SimpleMediumRSS\Item\ItemSet;
use SimpleMediumRSS\SimpleMediumRSS;

class SimpleMediumRSSTest extends TestCase
{
    public function testSimpleMediumRSSTest()
    {
        $simple = new SimpleMediumRSS('https://medium.com/feed/@Medium');

        $this->assertTrue($simple->getImage() instanceof Image);
        $this->assertTrue($simple->getItens() instanceof ItemSet);
        $this->assertTrue(is_string($simple->getTitle()));
        $this->assertTrue(is_string($simple->getDescription()));
        $this->assertTrue(is_string($simple->getLastBuildDate()));
    }

    public function testSimpleMediumRSSFromUserProfileTest()
    {
        $simple = new SimpleMediumRSS();
        $simple->fromUserProfile('Medium');

        $this->assertTrue($simple->getImage() instanceof Image);
        $this->assertTrue($simple->getItens() instanceof ItemSet);
        $this->assertTrue(is_string($simple->getTitle()));
        $this->assertTrue(is_string($simple->getDescription()));
        $this->assertTrue(is_string($simple->getLastBuildDate()));
    }

    public function testSimpleMediumRSSFromPublicationTest()
    {
        $simple = new SimpleMediumRSS();
        $simple->fromPublication('the-story');

        $this->assertTrue($simple->getImage() instanceof Image);
        $this->assertTrue($simple->getItens() instanceof ItemSet);
        $this->assertTrue(is_string($simple->getTitle()));
        $this->assertTrue(is_string($simple->getDescription()));
        $this->assertTrue(is_string($simple->getLastBuildDate()));
    }

    public function testSimpleMediumRSSInvalidArgumentExceptionTest()
    {
        $this->expectException(InvalidArgumentException::class);
        $simple = new SimpleMediumRSS('medium.com/feed/@Medium');
    }


    public function testSimpleMediumRSSSimpleLoadExceptionTest()
    {
        $this->expectException(SimpleLoadException::class);
        $simple = new SimpleMediumRSS('https://medium-no-existis.com/feed/@Medium');
    }
}
