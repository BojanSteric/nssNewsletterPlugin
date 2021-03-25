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
     * @var string $updatedAt
     */
    private $updatedAt;
    /**
     * @var string $content
     */
    private $content;
    
    /**
     * Newsletter constructor.
     * @param int|null $id
     * @param string $newsStatus
     * @param string|null $createdAt
     * @param string|null $updatedAt
     * @param string|null $content
     */
    public function __construct(
        int $id = null,
        string $newsStatus,
        string $createdAt = null,
        string $updatedAt = null,
        string $content = null
    ) {
        $this->id = $id;
        $this->status = $newsStatus;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->content = $content;
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
    public function getDateUpdated($format = null): ?string
    {
        if ($this->updatedAt !== '' && $this->updatedAt !== null) {
            if ($format) {
                $dt = new \DateTime();
                $dt->setTimestamp((int)$this->updatedAt);
                $this->updatedAt = $dt->format($format);
            }
        }
        return $this->updatedAt;
    }

    /**
     * @return string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }


}