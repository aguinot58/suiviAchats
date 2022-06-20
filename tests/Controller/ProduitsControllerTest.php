<?php

namespace App\Test\Controller;

use App\Entity\Produits;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProduitsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/produits/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = (static::getContainer()->get('doctrine'))->getManager();
        $this->repository = $this->manager->getRepository(Produits::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Produit index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'produit[idCat]' => 'Testing',
            'produit[manuelProd]' => 'Testing',
            'produit[infosProd]' => 'Testing',
            'produit[effaceProd]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Produits();
        $fixture->setIdCat('My Title');
        $fixture->setManuelProd('My Title');
        $fixture->setInfosProd('My Title');
        $fixture->setEffaceProd('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Produit');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Produits();
        $fixture->setIdCat('Value');
        $fixture->setManuelProd('Value');
        $fixture->setInfosProd('Value');
        $fixture->setEffaceProd('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'produit[idCat]' => 'Something New',
            'produit[manuelProd]' => 'Something New',
            'produit[infosProd]' => 'Something New',
            'produit[effaceProd]' => 'Something New',
        ]);

        self::assertResponseRedirects('/produits/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getIdCat());
        self::assertSame('Something New', $fixture[0]->getManuelProd());
        self::assertSame('Something New', $fixture[0]->getInfosProd());
        self::assertSame('Something New', $fixture[0]->getEffaceProd());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Produits();
        $fixture->setIdCat('Value');
        $fixture->setManuelProd('Value');
        $fixture->setInfosProd('Value');
        $fixture->setEffaceProd('Value');

        $$this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/produits/');
        self::assertSame(0, $this->repository->count([]));
    }
}
