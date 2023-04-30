<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

abstract class CustomApiTestCase extends ApiTestCase
{
    protected EntityManager $em;
    private string $token;
    private Client $clientWithCredentials;
    private ORMExecutor $executor;

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function setUp(): void
    {
        self::bootKernel([
            'environment' => 'test',
            'debug' => false,
        ]);
        $this->em = static::getContainer()->get('doctrine')->getManager();
        $connection = $this->em->getConnection();
        $connection->executeQuery('SET session_replication_role = replica;');
        $purger = new ORMPurger();
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_DELETE);
        $this->executor = new ORMExecutor($this->em, $purger);
        $purger->purge();
        $this->resetSequences($connection);
        $connection->executeQuery('SET session_replication_role = DEFAULT;');
        $connection->close();
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function tearDown(): void
    {
        $this->em->close();
        unset($this->em, $this->executor);
    }

    public function getClientWithCredentials(): Client
    {
        return $this->clientWithCredentials;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws \JsonException
     */
    protected function createClientWithCredentials(string $phone, string $password, $token = null): Client
    {
        $token = $token ?: $this->getToken($phone, $password);

        return $this->clientWithCredentials = static::createClient(
            [],
            ['headers' => ['authorization' => 'Bearer '.$token]]
        );
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws \JsonException
     */
    protected function getToken(string $phone, string $password): string
    {
        if (isset($this->token)) {
            return $this->token;
        }

        $response = static::createClient()->request(
            'POST',
            '/api/v1/login',
            [
                'headers' => ['accept' => ['application/json']],
                'json' => [
                    'phone' => $phone,
                    'password' => $password,
                ],
            ]
        );

        $this->assertResponseIsSuccessful();
        $data = json_decode($response->getContent() ?? '', false, 512, JSON_THROW_ON_ERROR);
        $this->token = $data->token;

        return $data->token;
    }

    protected function loadFixtures(string ...$fixtures): void
    {
        $loader = new Loader();

        foreach ($fixtures as $fixture) {
            $fixture = new $fixture();
            $loader->addFixture(new $fixture());
        }

        $this->executor->execute($loader->getFixtures(), true);
    }

    protected function loadFixture(FixtureInterface $fixture): void
    {
        $loader = new Loader();
        $loader->addFixture($fixture);
        $this->executor->execute($loader->getFixtures(), true);
    }

    protected function resetSequences(Connection $connection): void
    {
        $sequences = $connection->fetchAllAssociative('SELECT sequence_name FROM information_schema.sequences');

        foreach ($sequences as $sequence) {
            $query = 'SELECT setval(\'' . $sequence['sequence_name'] . '\', 1, false)';
            $connection->executeQuery($query);
        }
    }
}
