<?php

/**
 * This file is part of the Drupal Releases package.
 *
 * (c) Shawn Iwinski <shawn.iwinski@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SAI\DrupalReleases;

use Guzzle\Http\Client;

/**
 * @author Shawn Iwinski <shawn.iwinski@gmail.com>
 */
abstract class ClientAbstract extends \ArrayObject
{
    const BASE_URL = 'http://updates.drupal.org';

    protected static $client;

    protected $response;

    /**
     * @return \Guzzle\Http\Client
     */
    public static function getClient()
    {
        if (!isset(self::$client)) {
            self::$client = new Client(self::BASE_URL);
        }

        return self::$client;
    }

    /**
     * @return \Guzzle\Http\Message\RequestInterface
     */
    public function getRequest()
    {
        return is_object($this->response) ?
            $this->response->getRequest() : null;
    }

    /**
     * @return \Guzzle\Http\Message\Response
     */
    public function getResponse()
    {
        return is_object($this->response) ?
            $this->response : null;
    }
}
