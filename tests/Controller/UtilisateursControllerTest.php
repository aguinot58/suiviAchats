<?php

namespace App\Test\Controller;

use App\Entity\Utilisateurs;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UtilisateursControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/utilisateurs/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = (static::getContainer()->get('doctrine'))->getManager();
        $this->repository = $this->manager->getRepository(Utilisateurs::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Utilisateur index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'utilisateur[nomUser]' => 'Testing',
            'utilisateur[prenomUser]' => 'Testing',
            'utilisateur[mailUser]' => 'Testing',
            'utilisateur[mdpUser]' => 'Testing',
            'utilisateur[idRole]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Utilisateurs();
        $fixture->setNomUser('My Title');
        $fixture->setPrenomUser('My Title');
        $fixture->setMailUser('My Title');
        $fixture->setMdpUser('My Title');
        $fixture->setIdRole('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Utilisateur');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Utilisateurs();
        $fixture->setNomUser('Value');
        $fixture->setPrenomUser('Value');
        $fixture->setMailUser('Value');
        $fixture->setMdpUser('Value');
        $fixture->setIdRole('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'utilisateur[nomUser]' => 'Something New',
            'utilisateur[prenomUser]' => 'Something New',
            'utilisateur[mailUser]' => 'Something New',
            'utilisateur[mdpUser]' => 'Something New',
            'utilisateur[idRole]' => 'Something New',
        ]);

        self::assertResponseRedirects('/utilisateurs/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNomUser());
        self::assertSame('Something New', $fixture[0]->getPrenomUser());
        self::assertSame('Something New', $fixture[0]->getMailUser());
        self::assertSame('Something New', $fixture[0]->getMdpUser());
        self::assertSame('Something New', $fixture[0]->getIdRole());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Utilisateurs();
        $fixture->setNomUser('Value');
        $fixture->setPrenomUser('Value');
        $fixture->setMailUser('Value');
        $fixture->setMdpUser('Value');
        $fixture->setIdRole('Value');

        $$this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/utilisateurs/');
        self::assertSame(0, $this->repository->count([]));
    }
}
