<?php

namespace nickurt\PleskXml;

use nickurt\PleskXml\HttpClient\HttpClient;

class Client implements ClientInterface
{
    /** @var \nickurt\PleskXml\HttpClient\HttpClient */
    protected $client;

    /** @var array */
    private $classes = [
        'aps' => 'Aps',
        'certificates' => 'Certificates',
        'customers' => 'Customers',
        'databases' => 'Databases',
        'databasesservers' => 'DatabasesServers',
        'dns' => 'Dns',
        'extensions' => 'Extensions',
        'eventlog' => "EventLog",
        'ftp' => 'Ftp',
        'git' => 'Git',
        'ip' => 'Ip',
        'locales' => 'Locales',
        'logrotations' => 'LogRotations',
        'mail' => 'Mail',
        'nodejs' => 'Nodejs',
        'php' => 'Php',
        'plesk' => 'Plesk',
        'resellers' => 'Resellers',
        'resellersplans' => 'ResellersPlans',
        'secretkeys' => 'SecretKeys',
        'serviceplans' => 'ServicePlans',
        'serviceplansaddons' => 'ServicePlansAddons',
        'sessions' => 'Sessions',
        'sites' => 'Sites',
        'sitesaliases' => 'SitesAliases',
        'subdomains' => 'Subdomains',
        'subscriptions' => 'Subscriptions',
    ];

    /** @var array */
    private $options = [
        'port' => '8443',
        'version' => '1.6.9.1',
    ];

    /**
     * @param $method
     * @param $args
     * @return Api\Aps|Api\Certificates
     */
    public function __call($method, $args)
    {
        try {
            return $this->api($method);
        } catch (InvalidArgumentException $e) {
            throw new \BadMethodCallException(sprintf('Undefined method called:"%s"', $method));
        }
    }

    /**
     * @param $name
     * @return Api\Aps|Api\Certificates|Api\Customers|Api\Databases|Api\DatabasesServers|Api\Dns|Api\Extensions
     */
    public function api($name)
    {
        if (!isset($this->classes[$name])) {
            throw new \InvalidArgumentException(sprintf('Undefined method called:"%s"', $name));
        }

        $class = '\\nickurt\PleskXml\\Api\\' . $this->classes[$name];

        return new $class($this);
    }

    /**
     * @param string $username
     * @param string $password
     */
    public function setCredentials($username, $password)
    {
        $this->getHttpClient()->setHeaders([
            'HTTP_AUTH_LOGIN' => $username,
            'HTTP_AUTH_PASSWD' => $password,
        ]);
    }

    /**
     * @return HttpClient
     */
    public function getHttpClient()
    {
        if (!isset($this->client)) {
            $this->client = new HttpClient();
            $this->client->setOptions($this->options);
        }

        return $this->client;
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->getHttpClient()->setOptions([
            'host' => $host
        ]);
    }

    /**
     * @param int $port
     */
    public function setPort($port)
    {
        $this->getHttpClient()->setOptions([
            'port' => $port
        ]);
    }

    /**
     * @param string $secretKey
     */
    public function setSecretKey($secretKey)
    {
        $this->getHttpClient()->setHeaders([
            'KEY' => $secretKey
        ]);
    }
}
