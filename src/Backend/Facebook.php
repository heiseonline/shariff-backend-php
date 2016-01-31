<?php

namespace Heise\Shariff\Backend;

/**
 * Class Facebook.
 */
class Facebook extends Request implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'facebook';
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest($url)
    {
        $accessToken = $this->getAccessToken();
        if (null !== $accessToken) {
            $query = 'https://graph.facebook.com/v2.2/?id='.urlencode($url).'&'.$accessToken;
        } else {
            $query = 'https://graph.facebook.com/fql?q='
                     .urlencode('SELECT total_count FROM link_stat WHERE url="'.$url.'"');
        }

        return $this->createRequest($query);
    }

    /**
     * {@inheritdoc}
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
            $url = 'https://graph.facebook.com/oauth/access_token?client_id='.urlencode($this->config['app_id'])
                   .'&client_secret='.urlencode($this->config['secret']).'&grant_type=client_credentials';
            $request = $this->client->createRequest('GET', $url);

            return $this->client->send($request)->getBody(true);
        }

        return;
    }
}
