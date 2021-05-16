<?php

namespace Newsletter\Service;

class PostFormatter {

	public function formatDataNewsForm($postData)
	{
		$data['newsStatus'] = (string)$postData['newsStatus'];
		$data['createdAt'] = $postData['createdAt'] ?? date("Y-m-d H:i:s");
		$data['scheduledAt'] = (string)$postData['scheduledAt'];
		$data['title'] = (string)$postData['title'];
		$data['content'] = $this->parseNewsletterContent($postData);
		$data['templateName'] = str_replace('.php','',basename($postData['templateName']));
		$data['products'] = $this->serializeTemplateInfo($postData);

		return $data;
	}

    /**
     * Merges two separate arrays, one containing urls and the other containing image src attributes
     * and makes one array that maps the two arrays accordingly
     * @param $productUrls
     * @param $productImagesSrc
     * @return string
     */
    private function serializeTemplateInfo($params): string
    {
        $mergedProductParams = array_merge($params['url'],$params['src']);
        $templateInfo = [];
        $i = 0;
        $countNumberOfProducts = count($mergedProductParams);
        foreach($mergedProductParams as $mergedProductParam) {
            // The product info is in one array, to get the matching pairs we divide the whole array by to and add 1 for each loop
            $mappedSrcToUrl = ($countNumberOfProducts / 2) + $i;
            $productSrc = $mergedProductParams[$mappedSrcToUrl];
            $templateInfo[] = [
                'url' => $mergedProductParam,
                'src' => $productSrc
            ];
            $i++;
            // Stop the loop when the first set is finished, because we don't want to loop the whole array because we map the first half to the other
            if ($i === $countNumberOfProducts / 2) {
                break;
            }
        }

        if (isset($params['templateName'])) {
            $templateInfo['templateName'] = str_replace('.php','', basename($params['templateName']));
        }
        if (isset($params['title'])) {
            $templateInfo['title'] = [
                'title' => $params['templateTitle'],
                'titleUrl' => $params['templateTitleUrl']
            ];
        }
        return serialize($templateInfo);
    }

    /**
     * Loads the boilerplate template and replaces the strings accordingly to match the data from the user
     * @param $params
     * @return string
     */
    private function parseNewsletterContent($params): string
    {
        //Forms for inputs are php files but boilerplate templates are html
        $templateName = basename($params['templateName']);
        $templateName = str_replace('.php','.html',$templateName);
        $templateContent = file_get_contents(NEWSLETTER_DIR . 'template/Mail/NewsTemplate/boilerplate/' . $templateName);
        $templateContent = str_replace('#templateTitle#',$params['templateTitle'],$templateContent);
        foreach ($params['url'] as $key => $value) {
            $stringToBeReplaced = '#url' . $key . '#';
            $templateContent = str_replace($stringToBeReplaced, $value, $templateContent);
        }
        foreach ($params['src'] as $key => $value) {
            $stringToBeReplaced = '#src' . $key . '#';
            $templateContent = str_replace($stringToBeReplaced, $value, $templateContent);
        }
        if ($params['templateTitleUrl'] === '') {
            $params['templateTitleUrl'] = get_home_url();
        }
        $templateContent = str_replace('#titleUrl#',$params['templateTitleUrl'],$templateContent);
        if (!$templateContent) {
            return '';
        }
        return $templateContent;
    }
}