<?php

namespace Mautic\UserBundle\Security\Authentication\Token;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class PluginToken extends AbstractToken
{
    /**
     * @var array|\Symfony\Component\Security\Core\Role\RoleInterface[]
     */
    protected $providerKey;

    /**
     * @var string
     */
    protected $credentials;

    protected $authenticatingService;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @param array|\Symfony\Component\Security\Core\Role\RoleInterface[] $providerKey
     * @param null                                                        $authenticatingService
     * @param string                                                      $user
     * @param string                                                      $credentials
     * @param Response                                                    $response
     */
    public function __construct(
        $providerKey,
        $authenticatingService = null,
        $user = '',
        $credentials = '',
        array $roles = [],
        Response $response = null
    ) {
        parent::__construct($roles);

        if (empty($providerKey)) {
            throw new \InvalidArgumentException('$providerKey must not be empty.');
        }

        $this->setUser($user);
        $this->authenticatingService = $authenticatingService;
        $this->credentials           = $credentials;
        $this->providerKey           = $providerKey;
        $this->response              = $response;

        parent::setAuthenticated(count($roles) > 0);
    }

    /**
     * @return string
     */
    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * @return array|\Symfony\Component\Security\Core\Role\RoleInterface[]
     */
    public function getProviderKey()
    {
        return $this->providerKey;
    }

    public function getAuthenticatingService()
    {
        return $this->authenticatingService;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * {@inheritdoc}
     *
     * @return array<mixed>
     */
    public function __serialize(): array
    {
        return [$this->authenticatingService, $this->credentials, $this->providerKey, parent::__serialize()];
    }

    /**
     * {@inheritdoc}
     *
     * @param array<mixed> $data
     */
    public function __unserialize(array $data): void
    {
        [$this->authenticatingService, $this->credentials, $this->providerKey, $parentStr] = $data;
        parent::__unserialize($parentStr);
    }
}
