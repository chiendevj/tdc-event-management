<?php
// app/Services/FacebookService.php

namespace App\Services;

use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

class FacebookService
{
    protected $fb;

    public function __construct()
    {
        $this->fb = new Facebook([
            'app_id' => config('facebook.app_id'),
            'app_secret' => config('facebook.app_secret'),
            'default_graph_version' => 'v12.0',
        ]);
    }

    public function publishToPage($pageId, $message, $link = null, $imagePath = null)
    {
        try {
            $pageAccessToken = $this->getPageAccessToken($pageId);

            $data = [
                'message' => $message,
            ];

            if ($link) {
                $data['link'] = $link;
            }

            if ($imagePath) {
                $data['source'] = $this->fb->fileToUpload($imagePath);
            }

            $response = $this->fb->post('/' . $pageId . '/feed', $data, $pageAccessToken);

            return $response->getGraphNode()->getField('id');
        } catch (FacebookResponseException $e) {
            return 'Graph returned an error: ' . $e->getMessage();
        } catch (FacebookSDKException $e) {
            return 'Facebook SDK returned an error: ' . $e->getMessage();
        }
    }

    protected function getPageAccessToken($pageId)
    {
        try {
            $response = $this->fb->get("/$pageId?fields=access_token", config('facebook.app_id') . '|' . config('facebook.app_secret'));
            $page = $response->getGraphNode()->asArray();
            return $page['access_token'];
        } catch (FacebookResponseException $e) {
            return 'Graph returned an error: ' . $e->getMessage();
        } catch (FacebookSDKException $e) {
            return 'Facebook SDK returned an error: ' . $e->getMessage();
        }
    }
}
