<?php

namespace Kikwik\CommandBlameableBundle\Tests\Util\App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;

#[ORM\Entity]
class Article
{
    use BlameableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    public ?int $id = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $title = '';

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $content = '';

    public function __toString(): string
    {
        return (string)$this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): Article
    {
        $this->content = $content;
        return $this;
    }

}