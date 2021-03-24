<?php


namespace Newsletter\Repository;

use Newsletter\Mapper\Newsletter as Mapper;
use Newsletter\Model\Newsletter as Model;

class Newsletter
{
    /**
     * @var Mapper
     */
    private $mapper;

     /**
     * ProductDiscount constructor.
     * @param Mapper $mapper
     */
    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function create($data): ?int
    {
        return $this->mapper->insert($this->make($data));
    }

    public function getAll(int $page, int $perPage): array
    {
        $items = [];
        $data = $this->mapper->getAll($page, $perPage);
        foreach ($data as $item) {
                $items[] = $this->make($item);
        }
        return $items;
    }

    public function getNewsletterById(int $newsletterId) : Model
    {
        return $this->make($this->mapper->getNewsletterById($newsletterId));
    }

    public function update($data): void
    {
        $this->mapper->update($this->make($data));
    }
    
    public function delete(int $newsletterId): void
    {
        $this->mapper->delete($newsletterId);
    }
    
    private function make($data): Model
    {
        $newsId = null;
        $newsStatus = null;
        $dateCreated = null;
        $dateUpdated = null;
        $content = null;

        if (isset($data['newsId'])){
            $newsId = $data['newsId'];
        }
        if (isset($data['newsId'])) {
            $newsStatus = $data['newsId'];
        }
        if (isset($data['created_at'])) {
            $dateCreated = $data['created_at'];
        }
        if (isset($data['updatedAt'])) {
            $dateUpdated = $data['updatedAt'];
        }
        if (isset($data['content'])) {
            $content = $data['content'];
        }

        return new Model($newsId, $newsStatus, $dateCreated, $dateUpdated, $content);
    }
    

}