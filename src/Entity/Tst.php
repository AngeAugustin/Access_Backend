<?php

namespace App\Entity;

use App\Repository\TstRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TstRepository::class)]
class Tst
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
