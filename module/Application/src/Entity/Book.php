<?php

declare(strict_types=1);

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: "book")]
class Book
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface|string $id;


    #[ORM\Column(name: 'title', length: 255)]
    private string|null $title = null;

    #[ORM\Column(name: 'year', length: 4, type: Types::SMALLINT)]
    private int|null $year = null;

    #[ORM\Column(name: 'pages', type: Types::SMALLINT)]
    private int|null $pages = null;
    

    #[ORM\Column(name: 'posted_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $postedAt;


    public function getId(): string
    {
        return $this->id;
    }
}
