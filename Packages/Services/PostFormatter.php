<?php

namespace Service\PostFormatter;

class PostFormatter {

	public static function formatDataNewsForm($postData)
	{
		$data['newsStatus'] = (string)$postData['newsStatus'];
		$data['createdAt'] = $postData['createdAt'] ?? date( 'Y-m-d H:i:s', current_time( 'timestamp', 0 ) );
		$data['scheduledAt'] = (string)$postData['scheduledAt'];
		$data['title'] = (string)$postData['title'];
		$data['content'] = (string)$postData['content'];
		return $data;
	}
}
