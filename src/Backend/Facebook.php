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
    public function setConfig(array $config)
    {
        if (empty($config['app_id']) || empty($config['secret'])) {
            throw new \InvalidArgumentException('The Facebook app_id and secret must not be empty.');
        }
        parent::setConfig($config);
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest($url)
    {
        $accessToken = urlencode($this->config['app_id']) . '|' . urlencode($this->config['secret']);
        $query = 'https://graph.facebook.com/v17.0/?id=' . urlencode($url) . '&fields=og_object%7Bengagement%7D&access_token='
            . $accessToken;

        return new \GuzzleHttp\Psr7\Request('GET', $query);
    }

    /**
     * {@inheritdoc}
     */
    public function extractCount(array $data)
    {
        if (isset($data['og_object']['engagement']['count'])) {
            return $data['og_object']['engagement']['count'];
        }

        return 0;
    }
}
