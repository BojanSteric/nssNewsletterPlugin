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
        string $newsStatus,
        string $createdAt = null,
        string $scheduledAt = null,
        string $title,
        string $content = null,
	    string $templateName = null,
        string $products = null
    ) {
        $this->id = $id;
        $this->status = $newsStatus;
        $this->createdAt = $createdAt;
        $this->scheduledAt = $scheduledAt;
        $this->title = $title;
        $this->content = $content;
        $this->templateName = $templateName;
	    $this->products = $products;

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
    public function getDateCreated($format = null): ?string
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
    public function getDateScheduled($format = null): ?string
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
    public function getContent(): ?string
    {
        return $this->content;
    }
    
    /**
     * @return string
     */
    public function getTemplateName(): ?string
    {
        return $this->templateName;
    }
	/**
	 * @return string
	 */
	public function getProducts(): ?string
	{
		return $this->products;
	}

}