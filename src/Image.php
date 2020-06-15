<?php

namespace SimpleMediumRSS;

use SimpleXMLElement;

class Image
{

    private $url;
    private $title;
    private $link;

    public function __construct(SimpleXMLElement $image)
    {
        $this->url = (string) $image->url;
        $this->title = (string) $image->title;
        $this->link = (string) $image->link;
    }

    /**
     * Get the value of url
     */ 
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the value of link
     */ 
    public function getLink()
    {
        return $this->link;
    }
}
