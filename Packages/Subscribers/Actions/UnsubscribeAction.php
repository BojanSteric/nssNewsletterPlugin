<?php


namespace Newsletter\Subscribers\Actions;


use Subscriber\Mapper\Subscriber;

class UnsubscribeAction
{
    public static function unsubscribe($userCode)
    {
        $subscribersMapper = new Subscriber();
        $subscribersRepo = new \Subscriber\Repository\Subscriber($subscribersMapper);
        $user = $subscribersRepo->getUserBy('actionLink', $userCode);
        if ($user){
            $user->setActiveSince(null);
            $user->setEmailStatus($user::STATUS_UNSUBSCRIBED);
            $subscribersRepo->unsubscribeUser($user);
            $msg = 'Uspešno ste se odjavili';
            wp_send_json_success(['msg' => $msg]);
            return true;
        }
        $msg = 'Došlo je do greške prilikom odjave, pokušajte ponovo. Ako se ova greška ponovi kontaktirajte 
        administratora web stranice';
        wp_send_json_error(['msg' => $msg]);
        return false;
    }
}