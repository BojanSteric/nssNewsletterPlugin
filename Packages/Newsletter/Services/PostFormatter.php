<?php

namespace Newsletter\Service;

class PostFormatter {

	public static function formatDataNewsForm($postData)
	{
		$data['newsStatus'] = (string)$postData['newsStatus'];
		$data['createdAt'] = $postData['createdAt'] ?? date("Y-m-d H:i:s", new \DateTime() );
		$data['scheduledAt'] = (string)$postData['scheduledAt'];
		$data['title'] = (string)$postData['title'];
		$data['content'] = (string)$postData['content'];
		return $data;
	}
}