<?php


namespace Newsletter\Newsletter\Services;


use Newsletter\Model\Newsletter;
use PHPMailer\PHPMailer\Exception;

class Scheduler
{
    /**
     * @var Newsletter
     */
    private $newsletter;

    /**
     * Scheduler constructor.
     * @param Newsletter $newsletter
     */
    public function __construct(int $id)
    {
        $mapper = new \Newsletter\Mapper\Newsletter();
        $newsletterRepo = new \Newsletter\Repository\Newsletter($mapper);
        $this->newsletter = $newsletterRepo->getNewsletterById($id);
    }

    /**
     * Schedules send time for newsletter, if an event with that newsletter id already exists, remake it.
     * @throws Exception
     */
    public function scheduleSend()
    {
        $date = strtotime($this->newsletter->getDateScheduled());
        if ($date > time()) {
            $nextSchedule = wp_next_scheduled('gfNewsletterSend', ['newsletterId' => $this->newsletter->getId()]);
            if ($nextSchedule) {
                wp_unschedule_event($nextSchedule, 'gfNewsletterSend', ['newsletterId' => $this->newsletter->getId()]);
            }
            wp_schedule_single_event($date, 'gfNewsletterSend', ['newsletterId' => $this->newsletter->getId()]);
        } else {
            throw new \Exception('Vreme zakazivanja je u proslosti');
        }
    }

    public function deleteSchedule()
    {
        $nextSchedule = wp_next_scheduled('gfNewsletterSend', ['newsletterId' => $this->newsletter->getId()]);
        if ($nextSchedule) {
            wp_unschedule_event($nextSchedule, 'gfNewsletterSend', ['newsletterId' => $this->newsletter->getId()]);
        }
    }

}