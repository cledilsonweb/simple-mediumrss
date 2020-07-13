<?php

namespace SimpleMediumRSS\Item;

use DateTime;
use DOMDocument;
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

    /** @var DOMDocument*/
    private $contentDom;

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
    public function getDate(string $format = 'Y-m-d H:i:s')
    {
        $date = new DateTime($this->date);
        return $date->format($format);
    }

    /**
     * Get the value of updated
     */
    public function getUpdated(string $format = 'Y-m-d H:i:s')
    {
        $date = new DateTime($this->updated);
        return $date->format($format);
    }

    /**
     * Get the value of content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get the text of content
     */
    public function getContentText($length = 0, $completeLastWordLimit = 0, $paragraphBreak = ' ')
    {
        if (empty($this->contentDom)) {
            $this->contentDom = new DOMDocument('2.0');
            libxml_use_internal_errors(true);
            $this->contentDom->loadHTML(mb_convert_encoding($this->content, 'HTML-ENTITIES', 'UTF-8'));
            libxml_use_internal_errors(false);
        }

        $text = '';
        foreach ($this->contentDom->getElementsByTagName('p') as $value) {
            if(!empty($text)){
                $text .= $paragraphBreak;
            }
            $text .= trim(filter_var($value->nodeValue, FILTER_SANITIZE_STRING));
        }

        if ($length > 0) {
            if ($completeLastWordLimit > 0) {
                $total = $length + $completeLastWordLimit;
                for ($i = $length; $i < $total; $i++) {
                    if (preg_match("/^[\s0-9\pL]+$/u", mb_substr($text, $i, 1, 'utf-8')) === 0) {
                        $length = $i + 1;
                        break;
                    }
                }
            }
            return mb_substr($text, 0, $length);
        }

        return $text;
    }
}
