<?php

namespace Subscriber\Service;

use Subscriber\Model\Subscriber;

class PostFormatter {

	public static function formatDataNewsForm($postData)
	{
        $data['email'] = (string) $postData['email'];
        $user = get_user_by( 'email', $data['email'] );
		if($user){
			$data['wpUserId'] = $user->ID;
		}
        $data['emailStatus'] = $postData['emailStatus'];
		$data['createdAt'] = $postData['createdAt'] ?? date("Y-m-d H:i:s");
		$data['updatedAt'] = $postData['updatedAt'] ?? date("Y-m-d H:i:s");
		$data['firstName'] = (string) $postData['firstName'];
        $data['lastName'] = (string) $postData['lastName'];
		$data['actionLink'] = emailHash($postData['email']);
		return $data;
	}

	public static function formatDataNewSubscribers($postData)
	{
		$data['email'] = (string) $postData['email'];
		$user = get_user_by( 'email', $data['email'] );
        $data['wpUserId'] = null;
		if ($user) {
            $data['wpUserId'] = $user->ID;
        }
		$data['emailStatus'] = Subscriber::STATUS_NEW;
		$data['createdAt'] =  date("Y-m-d H:i:s") ;
		$data['updatedAt'] = $postData['updatedAt'] ?? null;
		$data['firstName'] = $postData['firstName'] ?? null;
		$data['lastName'] = $postData['lastName'] ?? null;
		$data['actionLink'] = emailHash($postData['email']);
		return $data;
	}
}

function emailHash($email)
{
	return password_hash($email, PASSWORD_BCRYPT, ["cost" => 8]);
}