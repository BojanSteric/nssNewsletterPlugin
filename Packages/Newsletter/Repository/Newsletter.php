<?php


namespace Newsletter\Repository;

use Newsletter\Mapper\Newsletter as Mapper;
use Newsletter\Model\Newsletter as Model;
use Newsletter\Newsletter\Services\Scheduler;

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

    public function create($data): int
    {
        try {
            $id = $this->mapper->insert($this->make($data));
            $scheduler = new Scheduler($id);
            $scheduler->scheduleSend();
            return $id;

        }catch (\Exception $e) {
            return false;
        }
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

    public function update($data)
    {
        try {
            $id = $this->mapper->update($this->make($data));
            $scheduler = new Scheduler($id);
            $scheduler->scheduleSend();
            return $id;

        }catch (\Exception $e) {
            return false;
        }
    }
    
    public function delete(int $newsletterId)
    {
        $this->mapper->delete($newsletterId);
    }
    
    private function make($data): Model
    {
        $newsId = null;
        $newsStatus = null;
        $createdAt = null;
        $scheduledAt = null;
        $title = null;
        $content = null;
        $templateName = null;
	    $products = null;

        if (isset($data['newsId'])){
            $newsId = $data['newsId'];
        }
        if (isset($data['newsStatus'])) {
            $newsStatus = $data['newsStatus'];
        }
        if (isset($data['createdAt'])) {
            $createdAt = $data['createdAt'];
        }
        if (isset($data['scheduledAt'])) {
            $scheduledAt = $data['scheduledAt'];
        }
        if (isset($data['title'])) {
            $title = $data['title'];
        }
        if (isset($data['content'])) {
            $content = $data['content'];
        }
        if (isset($data['templateName'])) {
            $templateName = $data['templateName'];
        }
	    if (isset($data['products'])) {
		    $products = $data['products'];
	    }

        return new Model($newsId, $newsStatus, $createdAt, $scheduledAt, $title, $content, $templateName,$products);
    }


}