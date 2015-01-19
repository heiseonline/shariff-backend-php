<?php

namespace Heise\Shariff\Backend;

class Facebook extends Request implements ServiceInterface
{
    protected $config;

    public function getName()
    {
        return 'facebook';
    }

    public function getRequest($url)
    {
        $accessToken = $this->getAccesToken();
        if (null !== $accessToken) {
            $query = 'https://graph.facebook.com/v2.2/?id=' . $url . '&' . $accessToken;
        } else {
            $query = 'https://graph.facebook.com/fql?q=SELECT total_count FROM link_stat WHERE url="'.$url.'"';
        }
        return $this->createRequest($query);
    }

    public function extractCount($data)
    {
        if (isset($data['data']) && isset($data['data'][0]) && isset($data['data'][0]['total_count'])) {
            return $data['data'][0]['total_count'];
        }
        if (isset($data['share']) && isset($data['share']['share_count'])) {
            return $data['share']['share_count'];
        }

        return null;
    }

    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    protected function getAccesToken()
    {
        if (isset($this->config['app_id']) && isset($this->config['secret'])) {
            try {
                return $this->client->createRequest(
                    'GET',
                    sprintf(
                        'https://graph.facebook.com/oauth/access_token?client_id=%s&client_secret=%s&grant_type=client_credentials',
                        $this->config['app_id'],
                        $this->config['secret']
                    )
                )->send()->getBody(true);
            } catch (\Exception $e) {
            }
        }
        return null;
    }
}
