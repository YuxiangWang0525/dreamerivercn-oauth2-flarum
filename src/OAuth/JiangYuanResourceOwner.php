<?php

/*
 * This file is part of the jiangyuan/oauth2-flarum extension.
 *
 * (c) 江愿文化 <support@dreameriver.cn>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JiangYuan\OAuth\OAuth;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Tool\ArrayAccessorTrait;

class JiangYuanResourceOwner implements ResourceOwnerInterface
{
    use ArrayAccessorTrait;

    /**
     * Raw response
     *
     * @var array
     */
    protected $response;

    /**
     * Creates new resource owner.
     *
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->response = $response;
    }

    /**
     * Returns the identifier of the authorized resource owner.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->getValueByKey($this->response, 'id');
    }

    /**
     * Returns the email address of the resource owner.
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->getValueByKey($this->response, 'email');
    }

    /**
     * Returns the name of the resource owner.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->getValueByKey($this->response, 'name');
    }

    /**
     * Returns the nickname of the resource owner.
     *
     * @return string|null
     */
    public function getNickname()
    {
        return $this->getValueByKey($this->response, 'username');
    }

    /**
     * Returns the avatar URL of the resource owner.
     *
     * @return string|null
     */
    public function getAvatar()
    {
        return $this->getValueByKey($this->response, 'avatar');
    }

    /**
     * Return all of the owner details available as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->response;
    }
}