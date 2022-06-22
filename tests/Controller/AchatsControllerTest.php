<?php

namespace App\Test\Controller;

use App\Entity\Achats;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AchatsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/achats/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = (static::getContainer()->get('doctrine'))->getManager();
        $this->repository = $this->manager->getRepository(Achats::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Achat index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'achat[dateAchat]' => 'Testing',
            'achat[dateGarAchat]' => 'Testing',
            'achat[prixAchat]' => 'Testing',
            'achat[photoTicketAchat]' => 'Testing',
            'achat[lieuAchat]' => 'Testing',
            'achat[idProd]' => 'Testing',
            'achat[idUser]' => 'Testing',
            'achat[idTypeLieu]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Achats();
        $fixture->setDateAchat('My Title');
        $fixture->setDateGarAchat('My Title');
        $fixture->setPrixAchat('My Title');
        $fixture->setPhotoTicketAchat('My Title');
        $fixture->setLieuAchat('My Title');
        $fixture->setIdProd('My Title');
        $fixture->setIdUser('My Title');
        $fixture->setIdTypeLieu('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Achat');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Achats();
        $fixture->setDateAchat('Value');
        $fixture->setDateGarAchat('Value');
        $fixture->setPrixAchat('Value');
        $fixture->setPhotoTicketAchat('Value');
        $fixture->setLieuAchat('Value');
        $fixture->setIdProd('Value');
        $fixture->setIdUser('Value');
        $fixture->setIdTypeLieu('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'achat[dateAchat]' => 'Something New',
            'achat[dateGarAchat]' => 'Something New',
            'achat[prixAchat]' => 'Something New',
            'achat[photoTicketAchat]' => 'Something New',
            'achat[lieuAchat]' => 'Something New',
            'achat[idProd]' => 'Something New',
            'achat[idUser]' => 'Something New',
            'achat[idTypeLieu]' => 'Something New',
        ]);

        self::assertResponseRedirects('/achats/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDateAchat());
        self::assertSame('Something New', $fixture[0]->getDateGarAchat());
        self::assertSame('Something New', $fixture[0]->getPrixAchat());
        self::assertSame('Something New', $fixture[0]->getPhotoTicketAchat());
        self::assertSame('Something New', $fixture[0]->getLieuAchat());
        self::assertSame('Something New', $fixture[0]->getIdProd());
        self::assertSame('Something New', $fixture[0]->getIdUser());
        self::assertSame('Something New', $fixture[0]->getIdTypeLieu());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Achats();
        $fixture->setDateAchat('Value');
        $fixture->setDateGarAchat('Value');
        $fixture->setPrixAchat('Value');
        $fixture->setPhotoTicketAchat('Value');
        $fixture->setLieuAchat('Value');
        $fixture->setIdProd('Value');
        $fixture->setIdUser('Value');
        $fixture->setIdTypeLieu('Value');

        $$this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/achats/');
        self::assertSame(0, $this->repository->count([]));
    }
}
