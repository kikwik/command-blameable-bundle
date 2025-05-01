<?php

namespace Kikwik\CommandBlameableBundle\Tests\Util;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\SchemaTool;
use Kikwik\CommandBlameableBundle\Entity\Log;
use Kikwik\CommandBlameableBundle\Tests\Util\Entity\Author;
use Kikwik\CommandBlameableBundle\Tests\Util\Entity\Tag;
use Kikwik\CommandBlameableBundle\Tests\Util\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Filesystem\Filesystem;

class CustomTestCase extends KernelTestCase
{
    private Container $container;

    protected function setUp(): void
    {
        parent::setUp();

        // boot the Symfony kernel
        self::bootKernel();

        // use static::getContainer() to access the service container
        $this->container = static::getContainer();

        //clear database
        $filesystem = new Filesystem();
        $filesystem->remove('var/database.db3');

        //updating a schema in sqlite database
        $entityManager = $this->getEntityManager();
        $metaData = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->updateSchema($metaData);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        restore_exception_handler();
    }


    protected function getEntityManager(): EntityManagerInterface
    {
        return $this->container->get('doctrine')->getManager();
    }

    protected function getRepository(string $entityClass): EntityRepository
    {
        return $this->getEntityManager()->getRepository($entityClass);
    }



}