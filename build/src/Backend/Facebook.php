<?php

namespace Heise\Shariff\Backend;

/**
 * Class Facebook
 *
 * @package Heise\Shariff\Backend
 */
class Facebook extends Request implements ServiceInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'facebook';
    }

    /**
     * @param string $url
     * @return \GuzzleHttp\Message\Request
     */
    public function getRequest($url)
    {
        $accessToken = $this->getAccessToken();
        if (null !== $accessToken) {
            $query = 'https://graph.facebook.com/v2.2/?id=' . $url . '&' . $accessToken;
        } else {
            $query = 'https://graph.facebook.com/fql?q=SELECT total_count FROM link_stat WHERE url="'.$url.'"';
        }
        return $this->createRequest($query);
    }

    /**
     * @param array $data
     * @return int
     */
    public function extractCount(array $data)
    {
        if (isset($data['data']) && isset($data['data'][0]) && isset($data['data'][0]['total_count'])) {
            return $data['data'][0]['total_count'];
        }
        if (isset($data['share']) && isset($data['share']['share_count'])) {
            return $data['share']['share_count'];
        }

        return 0;
    }

    /**
     * @return \GuzzleHttp\Stream\StreamInterface|null
     */
    protected function getAccessToken()
    {
        if (isset($this->config['app_id']) && isset($this->config['secret'])) {
            try {
                $url = 'https://graph.facebook.com/oauth/access_token?client_id=' .  $this->config['app_id']
                  . '&client_secret=' . $this->config['secret'] . '&grant_type=client_credentials';
                $request = $this->client->createRequest('GET', $url);
                return $this->client->send($request)->getBody(true);
            } catch (\Exception $e) {
            }
        }
        return null;
    }
}
