<?php

namespace App\Entity;

use App\Repository\OrangeGnomeRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Ulid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrangeGnomeRepository::class)]
final class OrangeGnome
{
    #[Assert\Ulid]
    #[ORM\Id]
    #[ORM\Column(length: 26, unique: true)]
    protected string $id;

    #[ORM\Column]
    private(set) int $data = 0;

    #[ORM\Column]
    private(set) int $otherData = 0;

    #[ORM\Column(type: 'datetime')]
    protected DateTime $createdAt;

    public function __construct()
    {
        $this->id = Ulid::generate();
        $this->createdAt = new DateTime();
    }

    public static function makeRandom(): self
    {
        $orangeGnome = new self();
        $orangeGnome->data = rand(1, 100);
        $orangeGnome->otherData = rand(1, 100);

        return $orangeGnome;
    }

    public function changeData(): void
    {
        $this->data = rand(1, 100);
    }

    public function changeOtherData(): void
    {
        $this->otherData = rand(1, 100);
    }

}
