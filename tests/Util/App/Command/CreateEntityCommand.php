<?php

namespace Kikwik\CommandBlameableBundle\Tests\Util\App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Kikwik\CommandBlameableBundle\Tests\Util\App\Entity\Article;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'test:create-entity'
)]
class CreateEntityCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('title', InputArgument::REQUIRED, 'Title of the article')
            ->addArgument('content', InputArgument::REQUIRED, 'Content of the article')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $article = new Article();
        $article->setTitle($input->getArgument('title'));
        $article->setContent($input->getArgument('content'));
        $this->entityManager->persist($article);
        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}