<?php

class Application_Model_News
{
	/**
	 * @var int
	 */
	protected $id;
	
	/**
	 * @var string
	 */
	protected $topic;
	
	/**
	 * @var string
	 */
	protected $text;
	
	/** 
	 * @param int $id
	 * @param string $topic
	 * @param string $text
	 */
	public function __construct($id = null, $topic = null, $text = null)
	{
		$this->id = $id;
		$this->topic = $topic;
		$this->text = $text;
	}
	
	/**
	 * @param string $topic
	 */
	public function setTopic($topic = null)
	{
		$this->topic = $topic;
	}
	
	/**
	 * @return string|boolean
	 */
	public function getTopic()
	{
		return (is_null($this->topic) ? false : $this->topic); 
	}
	
	/**
	 * @param string $text
	 */
	public function setText($text = null)
	{
		$this->text = $text;
	}
	
	/**
	 * @return string|boolean
	 */
	public function getText()
	{
		return (is_null($this->text) ? false : $this->text); 
	}
	
	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * @param int $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}
}