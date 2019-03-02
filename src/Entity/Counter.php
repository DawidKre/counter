<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     attributes={
 *          "order"={"id":"DESC"},
 *          "pagination_client_items_per_page"=true,
 *          "maximum_items_per_page": 100
 *     },
 * )
 * @ORM\Entity(repositoryClass="App\Repository\CounterRepository")
 * @ORM\HasLifecycleCallbacks()
 *
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
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $font;

    /**
     * @ORM\Column(type="integer")
     */
    private $time;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $color;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $fontSize;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $angle;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $xOffset;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $yOffset;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Template", inversedBy="counters")
     */
    private $template;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $identifier;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFont(): ?string
    {
        return $this->font;
    }

    public function setFont(?string $font): self
    {
        $this->font = $font;

        return $this;
    }

    public function getTime(): int
    {
        return $this->time;
    }

    public function setTime(int $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getFontSize(): ?int
    {
        return $this->fontSize;
    }

    public function setFontSize(?int $fontSize): self
    {
        $this->fontSize = $fontSize;

        return $this;
    }

    public function getAngle(): ?int
    {
        return $this->angle;
    }

    public function setAngle(?int $angle): self
    {
        $this->angle = $angle;

        return $this;
    }

    public function getXOffset(): ?int
    {
        return $this->xOffset;
    }

    public function setXOffset(?int $xOffset): self
    {
        $this->xOffset = $xOffset;

        return $this;
    }

    public function getYOffset(): ?int
    {
        return $this->yOffset;
    }

    public function setYOffset(?int $yOffset): self
    {
        $this->yOffset = $yOffset;

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

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setRandomIdentifier()
    {
        $this->identifier = $this->generateRandomString();
    }

    private function generateRandomString($length = 16, $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') :string
    {
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
