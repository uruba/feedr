<?php

namespace Feedr\Beans\Feed;

class Feed
{

	/** @var string */
	private $title;

	/** @var string */
	private $link;

	/** @var \DateTime */
	private $createdAt;

	/** @var \DateTime */
	private $updatedAt;

	/** @var FeedItem[] */
	private $items;

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getLink()
	{
		return $this->link;
	}

	/**
	 * @param string $link
	 */
	public function setLink($link)
	{
		$this->link = $link;
	}

	/**
	 * @return \DateTime
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	/**
	 * @param \DateTime $createdAt
	 */
	public function setCreatedAt($createdAt)
	{
		$this->createdAt = $createdAt;
	}

	/**
	 * @return \DateTime
	 */
	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}

	/**
	 * @param \DateTime $updatedAt
	 */
	public function setUpdatedAt($updatedAt)
	{
		$this->updatedAt = $updatedAt;
	}

	/**
	 * @return FeedItem[]
	 */
	public function getItems()
	{
		return $this->items;
	}

	/**
	 * @param FeedItem[] $items
	 */
	public function setItems($items)
	{
		$this->items = $items;
	}

	/**
	 * @param FeedItem $item
	 */
	public function addItem($item)
	{
		$this->items[] = $item;
	}

}
