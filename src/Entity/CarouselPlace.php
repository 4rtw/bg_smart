<?php

namespace App\Entity;

use App\Repository\CarouselPlaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarouselPlaceRepository::class)
 */
class CarouselPlace
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $placeName;

    /**
     * @ORM\ManyToMany(targetEntity=Carousel::class, inversedBy="carouselPlaces")
     */
    private $carousel;

    public function __construct()
    {
        $this->carousel = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlaceName(): ?string
    {
        return $this->placeName;
    }

    public function setPlaceName(string $placeName): self
    {
        $this->placeName = $placeName;

        return $this;
    }

    /**
     * @return Collection<int, Carousel>
     */
    public function getCarousel(): Collection
    {
        return $this->carousel;
    }

    public function addCarousel(Carousel $carousel): self
    {
        if (!$this->carousel->contains($carousel)) {
            $this->carousel[] = $carousel;
        }

        return $this;
    }

    public function removeCarousel(Carousel $carousel): self
    {
        $this->carousel->removeElement($carousel);

        return $this;
    }

    public function __toString()
    {
        return $this->placeName;
    }
}
