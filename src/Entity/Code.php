<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CodeRepository")
 * @UniqueEntity("code")
 */
class Code
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="code", type="string", length=13, unique=true)
     */
    private $code;

    /**
     * @ORM\Column(name="data_added", type="datetime", options={"default"="CURRENT_TIMESTAMP"})
     */
    private $dataAdded;

    public function getId()
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getDataAdded(): ?\DateTimeInterface
    {
        return $this->dataAdded;
    }

    public function setDataAdded(\DateTimeInterface $dataAdded): self
    {
        $this->dataAdded = $dataAdded;

        return $this;
    }
}

