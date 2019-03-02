<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CounterRepository")
 * @ApiResource()
 */
class Counter
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $time;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Template", inversedBy="counters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $template;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dateColor;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $textColor;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $font;

    /**
     * @ORM\Column(type="integer")
     */
    private $dateFontSize;

    /**
     * @ORM\Column(type="integer")
     */
    private $textFontSize;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getTemplate(): ?Template
    {
        return $this->template;
    }

    public function setTemplate(?Template $template): self
    {
        $this->template = $template;

        return $this;
    }

    public function getDateColor(): ?string
    {
        return $this->dateColor;
    }

    public function setDateColor(string $dateColor): self
    {
        $this->dateColor = $dateColor;

        return $this;
    }

    public function getTextColor(): ?string
    {
        return $this->textColor;
    }

    public function setTextColor(string $textColor): self
    {
        $this->textColor = $textColor;

        return $this;
    }

    public function getFont(): ?string
    {
        return $this->font;
    }

    public function setFont(string $font): self
    {
        $this->font = $font;

        return $this;
    }

    public function getDateFontSize(): ?int
    {
        return $this->dateFontSize;
    }

    public function setDateFontSize(int $dateFontSize): self
    {
        $this->dateFontSize = $dateFontSize;

        return $this;
    }

    public function getTextFontSize(): ?int
    {
        return $this->textFontSize;
    }

    public function setTextFontSize(int $textFontSize): self
    {
        $this->textFontSize = $textFontSize;

        return $this;
    }
}
