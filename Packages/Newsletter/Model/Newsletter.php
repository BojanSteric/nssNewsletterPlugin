<?php


namespace Newsletter\Model;

class Newsletter
{
    /**
     * @var int $id
     */
    private $id;
    /**
     * @var string $status
     */
    private $status;
    /**
     * @var string $createdAt
     */
    private $createdAt;
    /**
     * @var string $scheduledAt
     */
    private $scheduledAt;
    /**
     * @var string $title
     */
    private $title;
    /**
     * @var string $content
     */
    public $content;
    /**
     * @var string $templateName
     */
    public $templateName;
    /**
     * @var string $products
     */
    public $products;

    private $stats;
    private $sentCount;

    /**
     * Newsletter constructor.
     * @param int|null $id
     * @param string $newsStatus
     * @param string|null $createdAt
     * @param string|null $scheduledAt
     * @param string $title
     * @param string|null $content
     * @param string|null $templateName
     * @param string|null $products
     */
    public function __construct(
        int $id = null,
        string $status,
        string $createdAt = null,
        string $scheduledAt = null,
        string $title,
        string $content = null,
	    string $templateName = null,
        string $products = null,
        string $sentCount = null
    ) {
        $this->id = $id;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->scheduledAt = $scheduledAt;
        $this->title = $title;
        $this->content = $content;
        $this->templateName = $templateName;
	    $this->products = $products;
	    $this->sentCount = $sentCount;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getDateCreated($format = null)
    {
        if ($this->createdAt !== '' && $this->createdAt !== null) {
            if ($format) {
                $dt = new \DateTime();
                $dt->setTimestamp((int)$this->createdAt);
                $this->createdAt = $dt->format($format);
            }
        }
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getDateScheduled($format = null)
    {
        if ($this->scheduledAt !== '' && $this->scheduledAt !== null) {
            if ($format) {
                $dt = new \DateTime();
                $dt->setTimestamp((int)$this->scheduledAt);
                $this->scheduledAt = $dt->format($format);
            }
        }
        return $this->scheduledAt;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    public function setStats($stats)
    {
        $this->stats = $stats;
    }

    public function getStats()
    {
        return ($this->status === 'sending') ? $this->stats : $this->sentCount;
    }
    
    /**
     * @return string
     */
    public function getTemplateName()
    {
        return $this->templateName;
    }
	/**
	 * @return string
	 */
	public function getProducts()
	{
		return $this->products;
	}

}