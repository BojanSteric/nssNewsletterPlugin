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
		return $data;
	}
}