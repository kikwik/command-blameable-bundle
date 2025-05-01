<?php

namespace Kikwik\CommandBlameableBundle\Tests\Functional;

use Kikwik\CommandBlameableBundle\Tests\Util\App\Entity\Article;
use Kikwik\CommandBlameableBundle\Tests\Util\CustomTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\ApplicationTester;
use Symfony\Component\Console\Tester\CommandTester;

class CommandTest extends CustomTestCase
{
    public function testCreateAndUpdateEntityCommand()
    {
        // run command that create an article
        $application = new Application(self::$kernel);
        $application->setAutoExit(false);
        $tester = new ApplicationTester($application);
        $tester->run([
            'command' => 'test:create-entity',
            'title' => 'Command created article',
            'content' => 'My content',
        ]);

        // check database
        $articles = $this->getRepository(Article::class)->findAll();
        $this->assertCount(1, $articles);
        $this->assertEquals('Command created article', $articles[0]->getTitle());
        $this->assertEquals('My content', $articles[0]->getContent());
        $this->assertEquals('test:create-entity', $articles[0]->getCreatedBy());
        $this->assertEquals('test:create-entity', $articles[0]->getUpdatedBy());

        // run command that update the article
        $application = new Application(self::$kernel);
        $application->setAutoExit(false);
        $tester = new ApplicationTester($application);
        $tester->run([
            'command' => 'test:update-entity',
            'id'=> $articles[0]->getId(),
            'title' => 'Modified title',
        ]);

        // check database
        $articles = $this->getRepository(Article::class)->findAll();
        $this->assertCount(1, $articles);
        $this->assertEquals('Modified title', $articles[0]->getTitle());
        $this->assertEquals('My content', $articles[0]->getContent());
        $this->assertEquals('test:create-entity', $articles[0]->getCreatedBy());
        $this->assertEquals('test:update-entity', $articles[0]->getUpdatedBy());
    }
}