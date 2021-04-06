<?php


namespace Subscriber\Model;

class Subscriber
{
    /**
     * @var int $userId
     */
    private $userId;
    /**
     * @var int $wpUserId
     */
    private $wpUserId;
    /**
     * @var string $email
     */
    private $email;
    /**
     * @var string $emailStatus
     */
    private $emailStatus;
    /**
     * @var string $actionLink
     */
    private $actionLink;
    /**
     * @var string $firstName
     */
    private $firstName;
    /**
     * @var string $lastName
     */
    private $lastName;
    /**
     * @var string $createdAt
     */
    private $createdAt;
     /**
     * @var string $updatedAt
     */
    private $updatedAt;
    /**
     * @var string $updatedAt
     */
    private $activeSince;
    
    /**
     * Subscriber constructor.
     * @param int|null $userId
     * @param int|null $wpUserId
     * @param string $email
     * @param string $emailStatus
     * @param string $actionLink
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $createdAt
     * @param string|null $updatedAt
     * @param string|null $activeSince
     */
    public function __construct(
        int $userId = null,
        int $wpUserId = null,
        string $email,
        string $emailStatus,
        string $actionLink,
        string $firstName = null,
        string $lastName = null,
        string $createdAt = null,
        string $updatedAt = null,
        string $activeSince = null
    ) {
        $this->userId = $userId;
        $this->wpUserId = $wpUserId;
        $this->email = $email;
        $this->emailStatus = $emailStatus;
        $this->actionLink = $actionLink;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->activeSince = $activeSince;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getWpUserId(): ?int
    {
        return $this->wpUserId;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

     /**
     * @return string
     */
    public function getEmailStatus(): string
    {
        return $this->emailStatus;
    }

    /**
     * @return string
     */
    public function getActionLink(): string
    {
        return $this->actionLink;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
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
    public function getDateUpdated($format = null)
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
    public function getActiveSince($format = null)
    {
        if ($this->activeSince !== '' && $this->activeSince !== null) {
            if ($format) {
                $dt = new \DateTime();
                $dt->setTimestamp((int)$this->activeSince);
                $this->activeSince = $dt->format($format);
            }
        }
        return $this->activeSince;
    }

    public function setActiveSince($time)
    {
        $this->activeSince = $time;
    }

    public function setEmailStatus($status)
    {
        $this->emailStatus = $status;
    }
}