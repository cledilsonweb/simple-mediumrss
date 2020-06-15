<?php

namespace SimpleMediumRSS\Item;

use SimpleXMLElement;

class Item
{
    /** @var SimpleXMLElement */
    private $item;

    private $link;
    private $title;
    private $categories;
    private $date;
    private $updated;
    private $content;

    private $contentNamespace = 'http://purl.org/rss/1.0/modules/content/';
    private $updatedNamespace = 'http://www.w3.org/2005/Atom';

    public function __construct(SimpleXMLElement $item)
    {
        $this->item = $item;
        $this->link = (string) $item->link;
        $this->title = (string) $item->title;
        $this->categories = $this->categoryToArray($item->category);
        $this->date = (string) $item->pubDate;
        $this->updated = (string) $this->getUpdatedFromNamespace($item);
        $this->content = (string) $this->getContentFromNamespace($item);
    }

    private function categoryToArray($categories): array
    {
        $categoryArray = [];
        if (is_iterable($categories)) {
            foreach ($categories as $category) {
                $categoryArray[] = (string) $category;
            }
        }
        return $categoryArray;
    }

    private function getContentFromNamespace($item)
    {
        $content = $item->children($this->contentNamespace);
        return $content->encoded;
    }

    private function getUpdatedFromNamespace($item)
    {
        $atom = $item->children($this->updatedNamespace);
        return $atom->updated;
    }

    /**
     * Get the value of link
     */ 
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the value of categories
     */ 
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Get the value of updated
     */ 
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }
}
