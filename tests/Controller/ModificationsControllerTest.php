<?php

namespace App\Test\Controller;

use App\Entity\Modifications;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ModificationsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/modifications/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = (static::getContainer()->get('doctrine'))->getManager();
        $this->repository = $this->manager->getRepository(Modifications::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Modification index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'modification[typeModif]' => 'Testing',
            'modification[descModif]' => 'Testing',
            'modification[dateModif]' => 'Testing',
            'modification[idProd]' => 'Testing',
            'modification[idUser]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Modifications();
        $fixture->setTypeModif('My Title');
        $fixture->setDescModif('My Title');
        $fixture->setDateModif('My Title');
        $fixture->setIdProd('My Title');
        $fixture->setIdUser('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Modification');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Modifications();
        $fixture->setTypeModif('Value');
        $fixture->setDescModif('Value');
        $fixture->setDateModif('Value');
        $fixture->setIdProd('Value');
        $fixture->setIdUser('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'modification[typeModif]' => 'Something New',
            'modification[descModif]' => 'Something New',
            'modification[dateModif]' => 'Something New',
            'modification[idProd]' => 'Something New',
            'modification[idUser]' => 'Something New',
        ]);

        self::assertResponseRedirects('/modifications/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTypeModif());
        self::assertSame('Something New', $fixture[0]->getDescModif());
        self::assertSame('Something New', $fixture[0]->getDateModif());
        self::assertSame('Something New', $fixture[0]->getIdProd());
        self::assertSame('Something New', $fixture[0]->getIdUser());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Modifications();
        $fixture->setTypeModif('Value');
        $fixture->setDescModif('Value');
        $fixture->setDateModif('Value');
        $fixture->setIdProd('Value');
        $fixture->setIdUser('Value');

        $$this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/modifications/');
        self::assertSame(0, $this->repository->count([]));
    }
}
