<?php


namespace BehatTests\Api;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

$_SERVER['KERNEL_DIR'] = __DIR__ . '/../../../app/';

class KernelWebTestCase extends WebTestCase
{
    /**
     * @var Client
     */
    protected $client;

    public function __construct()
    {
        $this->client = self::createClient();
        parent::__construct();
    }
}