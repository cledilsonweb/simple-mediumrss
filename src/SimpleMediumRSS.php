<?php

namespace SimpleMediumRSS;

use DateTime;
use Error;
use Exception;
use SimpleMediumRSS\Exception\InvalidArgumentException;
use SimpleMediumRSS\Exception\SimpleLoadException;
use SimpleMediumRSS\Item\ItemSet;
use SimpleXMLElement;

/**
 * Main class. Reads Medium RSS feed.
 * @author cledilsonweb
 */
class SimpleMediumRSS
{

    /** @var SimpleXMLElement */
    private $xml;
    private $title;
    private $description;
    private $lastBuildDate;
    /**
     * @var Image
     */
    private $image;
    /**
     * @var ItemSet
     */
    private $itens;

    private $rssUrl;
    private $baseUrl = 'https://medium.com/feed/';


    /**
     * @param string|null $rssUrl
     */
    public function __construct(string $rssUrl = null)
    {
        if (!empty($rssUrl)) {
            if (!filter_var($rssUrl, FILTER_VALIDATE_URL)) {
                throw new InvalidArgumentException("Argument is not a valid URL");
            }

            $this->init($rssUrl);
        }
    }

    /**
     * Access Medium RSS using user profile
     * 
     * @param string $user
     * 
     * @return void
     */
    public function fromUserProfile(string $user): void
    {
        $this->init($this->baseUrl . '@' . $user);
    }

    /**
     * Access Medium RSS using the publication. (Example: the-story)
     * 
     * @param string $publication
     * 
     * @return void
     */
    public function fromPublication(string $publication): void
    {
        $this->init($this->baseUrl . $publication);
    }

    /**
     * Initializes the object
     * 
     * @param mixed $rssUrl
     * 
     * @return void
     */
    private function init($rssUrl): void
    {
        try {
            $this->xml = simplexml_load_file($rssUrl);
            if (!$this->xml) {
                throw new SimpleLoadException("Could not load URL: " . $rssUrl);
            }
        } catch (Error | Exception $e) {
            throw new SimpleLoadException("Could not load URL: " . $rssUrl);
        }

        $channel = $this->xml->channel;
        $this->title = (string) $channel->title;
        $this->description = (string) $channel->description;
        $this->lastBuildDate = (string) $channel->lastBuildDate;
        $this->image = new Image($channel->image);
        $this->itens = new ItemSet($channel->item);
    }

    /**
     * Get the value of image
     *
     * @return  Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Get the value of itens
     *
     * @return  ItemSet
     */
    public function getItens()
    {
        return $this->itens;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the value of lastBuildDate
     */
    public function getLastBuildDate(string $format = 'Y-m-d H:i:s')
    {
        $date = new DateTime($this->lastBuildDate);
        return $date->format($format);
    }
}
