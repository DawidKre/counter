<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TemplateRepository")
 * @ApiResource()
 */
class Template
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Counter", mappedBy="template")
     */
    private $counters;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function __construct()
    {
        $this->counters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Counter[]
     */
    public function getCounters(): Collection
    {
        return $this->counters;
    }

    public function addCounter(Counter $counter): self
    {
        if (!$this->counters->contains($counter)) {
            $this->counters[] = $counter;
            $counter->setTemplate($this);
        }

        return $this;
    }

    public function removeCounter(Counter $counter): self
    {
        if ($this->counters->contains($counter)) {
            $this->counters->removeElement($counter);
            // set the owning side to null (unless already changed)
            if ($counter->getTemplate() === $this) {
                $counter->setTemplate(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
