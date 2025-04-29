<?php

namespace App\Tests\Controller;

use App\Entity\Licences;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class LicencesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $licenceRepository;
    private string $path = '/licences/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->licenceRepository = $this->manager->getRepository(Licences::class);

        foreach ($this->licenceRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Licence index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'licence[tenant]' => 'Testing',
            'licence[name]' => 'Testing',
            'licence[clientId]' => 'Testing',
            'licence[api_name]' => 'Testing',
            'licence[licence_key]' => 'Testing',
            'licence[status]' => 'Testing',
            'licence[creationDate]' => 'Testing',
            'licence[expirationDate]' => 'Testing',
            'licence[usageLimite]' => 'Testing',
            'licence[usageCount]' => 'Testing',
            'licence[rateLimit]' => 'Testing',
            'licence[lastUsedAt]' => 'Testing',
            'licence[createdBy]' => 'Testing',
            'licence[description]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->licenceRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Licences();
        $fixture->setTenant('My Title');
        $fixture->setName('My Title');
        $fixture->setClientId('My Title');
        $fixture->setApi_name('My Title');
        $fixture->setLicence_key('My Title');
        $fixture->setStatus('My Title');
        $fixture->setCreationDate('My Title');
        $fixture->setExpirationDate('My Title');
        $fixture->setUsageLimite('My Title');
        $fixture->setUsageCount('My Title');
        $fixture->setRateLimit('My Title');
        $fixture->setLastUsedAt('My Title');
        $fixture->setCreatedBy('My Title');
        $fixture->setDescription('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Licence');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Licences();
        $fixture->setTenant('Value');
        $fixture->setName('Value');
        $fixture->setClientId('Value');
        $fixture->setApi_name('Value');
        $fixture->setLicence_key('Value');
        $fixture->setStatus('Value');
        $fixture->setCreationDate('Value');
        $fixture->setExpirationDate('Value');
        $fixture->setUsageLimite('Value');
        $fixture->setUsageCount('Value');
        $fixture->setRateLimit('Value');
        $fixture->setLastUsedAt('Value');
        $fixture->setCreatedBy('Value');
        $fixture->setDescription('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'licence[tenant]' => 'Something New',
            'licence[name]' => 'Something New',
            'licence[clientId]' => 'Something New',
            'licence[api_name]' => 'Something New',
            'licence[licence_key]' => 'Something New',
            'licence[status]' => 'Something New',
            'licence[creationDate]' => 'Something New',
            'licence[expirationDate]' => 'Something New',
            'licence[usageLimite]' => 'Something New',
            'licence[usageCount]' => 'Something New',
            'licence[rateLimit]' => 'Something New',
            'licence[lastUsedAt]' => 'Something New',
            'licence[createdBy]' => 'Something New',
            'licence[description]' => 'Something New',
        ]);

        self::assertResponseRedirects('/licences/');

        $fixture = $this->licenceRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getTenant());
        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getClientId());
        self::assertSame('Something New', $fixture[0]->getApi_name());
        self::assertSame('Something New', $fixture[0]->getLicence_key());
        self::assertSame('Something New', $fixture[0]->getStatus());
        self::assertSame('Something New', $fixture[0]->getCreationDate());
        self::assertSame('Something New', $fixture[0]->getExpirationDate());
        self::assertSame('Something New', $fixture[0]->getUsageLimite());
        self::assertSame('Something New', $fixture[0]->getUsageCount());
        self::assertSame('Something New', $fixture[0]->getRateLimit());
        self::assertSame('Something New', $fixture[0]->getLastUsedAt());
        self::assertSame('Something New', $fixture[0]->getCreatedBy());
        self::assertSame('Something New', $fixture[0]->getDescription());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Licences();
        $fixture->setTenant('Value');
        $fixture->setName('Value');
        $fixture->setClientId('Value');
        $fixture->setApi_name('Value');
        $fixture->setLicence_key('Value');
        $fixture->setStatus('Value');
        $fixture->setCreationDate('Value');
        $fixture->setExpirationDate('Value');
        $fixture->setUsageLimite('Value');
        $fixture->setUsageCount('Value');
        $fixture->setRateLimit('Value');
        $fixture->setLastUsedAt('Value');
        $fixture->setCreatedBy('Value');
        $fixture->setDescription('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/licences/');
        self::assertSame(0, $this->licenceRepository->count([]));
    }
}
