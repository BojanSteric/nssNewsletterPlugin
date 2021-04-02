<?php

namespace Subscriber\Service;

class PostFormatter {

	public static function formatDataNewsForm($postData)
	{
        $data['email'] = (string)$postData['email'];
        $user = get_user_by( 'email', $data['email'] );
        $data['wpUserId'] = $user->ID;
		$data['emailStatus'] = (string)$postData['emailStatus'];
		$data['createdAt'] = $postData['createdAt'] ?? date("Y-m-d H:i:s", new \DateTime() );
		$data['updatedAt'] = (string)$postData['updatedAt'];
		$data['firstName'] = (string)$postData['firstName'];
        $data['lastName'] = (string)$postData['lastName'];
		$data['actionLink'] = emailHash($postData['email']);
		return $data;
	}
	public static function formatDataNewSubscribers($postData)
	{
		$data['email'] = (string)$postData['email'];
		$user = get_user_by( 'email', $data['email'] );
		$data['wpUserId'] = $user->ID;
		$data['emailStatus'] = 'not confirmed';
		$data['createdAt'] =  date("Y-m-d H:i:s") ;
		$data['updatedAt'] = (string)$postData['updatedAt'] ?? NULL;
		$data['firstName'] = (string)$postData['firstName'] ?? NULL;
		$data['lastName'] = (string)$postData['lastName'] ?? NULL;
		$data['actionLink'] = emailHash($postData['email']);
		return $data;
	}
}

function emailHash($email)
{
	return password_hash($email, PASSWORD_BCRYPT);
}