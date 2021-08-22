<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Planet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="integer", name="rotation_period")
     */
    private $rotationPeriod;

    /**
     * @ORM\Column(type="integer", name="orbital_period")
     */
    private $orbitalPeriod;

    /**
     * @ORM\Column(type="integer")
     */
    private $diameter;

    /**
     * @ORM\Column(type="integer", name="films_count")
     */
    private $filmsCount;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="datetime")
     */
    private $edited;

    /**
     * @ORM\Column(type="string")
     */
    private $url;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId($id): Planet
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): Planet
    {
        $this->name = $name;
        return $this;
    }

    public function getRotationPeriod(): int
    {
        return $this->rotationPeriod;
    }

    public function setRotationPeriod($rotationPeriod): Planet
    {
        $this->rotationPeriod = $rotationPeriod;
        return $this;
    }

    public function getOrbitalPeriod(): int
    {
        return $this->orbitalPeriod;
    }

    public function setOrbitalPeriod($orbitalPeriod): Planet
    {
        $this->orbitalPeriod = $orbitalPeriod;
        return $this;
    }

    public function getDiameter(): int
    {
        return $this->diameter;
    }

    public function setDiameter($diameter): Planet
    {
        $this->diameter = $diameter;
        return $this;
    }

    public function getFilmsCount(): int
    {
        return $this->filmsCount;
    }

    public function setFilmsCount($filmsCount): Planet
    {
        $this->filmsCount = $filmsCount;
        return $this;
    }

    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    public function setCreated($created): Planet
    {
        $this->created = $created;
        return $this;
    }

    public function getEdited(): \DateTime
    {
        return $this->edited;
    }

    public function setEdited($edited): Planet
    {
        $this->edited = $edited;
        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl($url): Planet
    {
        $this->url = $url;
        return $this;
    }
}