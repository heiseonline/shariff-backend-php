<?php

namespace Heise\Shariff\Backend;

use Psr\Http\Message\RequestInterface;

/**
 * Class Facebook.
 */
class Facebook extends Request implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'facebook';
    }

    /**
     * {@inheritdoc}
     */
    public function setConfig(array $config): void
    {
        if (empty($config['app_id']) || empty($config['secret'])) {
            throw new \InvalidArgumentException('The Facebook app_id and secret must not be empty.');
        }
        parent::setConfig($config);
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest(string $url): RequestInterface
    {
        $accessToken = urlencode($this->config['app_id']) . '|' . urlencode($this->config['secret']);
        $query = 'https://graph.facebook.com/v7.0/?id=' . urlencode($url) . '&fields=engagement&access_token='
            . $accessToken;

        return new \GuzzleHttp\Psr7\Request('GET', $query);
    }

    /**
     * {@inheritdoc}
     */
    public function extractCount(array $data): int
    {
        if (isset(
            $data['engagement']['reaction_count'],
            $data['engagement']['comment_count'],
            $data['engagement']['share_count']
        )) {
            return $data['engagement']['reaction_count']
                + $data['engagement']['comment_count']
                + $data['engagement']['share_count'];
        }

        return 0;
    }
}
