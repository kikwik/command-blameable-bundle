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
    name: 'test:update-entity'
)]
class UpdateEntityCommand extends Command
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
            ->addArgument('id', InputArgument::REQUIRED, 'Id of the article')
            ->addArgument('title', InputArgument::REQUIRED, 'New title for the article')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $article = $this->entityManager->getRepository(Article::class)->find($input->getArgument('id'));
        $article->setTitle($input->getArgument('title'));
        $this->entityManager->persist($article);
        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}