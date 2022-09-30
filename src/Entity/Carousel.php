<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CarouselRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *   normalizationContext={"groups"={"read:imageUrl"}},
 *   collectionOperations={"get"},
 *   itemOperations={"get"})
 * @ORM\Entity(repositoryClass=CarouselRepository::class)
 */
class Carousel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:imageUrl"})
     */
    private $imageurl;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=ImageTag::class, inversedBy="carousels")
     * @ORM\JoinColumn(nullable=true)
     */
    private $tag;

    /**
     * @ORM\ManyToMany(targetEntity=CarouselPlace::class, mappedBy="carousel")
     */
    private $carouselPlaces;

    public function __construct()
    {
        $this->carouselPlaces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImageurl(): ?string
    {
        return $this->imageurl;
    }

    public function setImageurl(string $imageurl): self
    {
        $this->imageurl = $imageurl;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTag(): ?ImageTag
    {
        return $this->tag;
    }

    public function setTag(?ImageTag $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @return Collection<int, CarouselPlace>
     */
    public function getCarouselPlaces(): Collection
    {
        return $this->carouselPlaces;
    }

    public function addCarouselPlace(CarouselPlace $carouselPlace): self
    {
        if (!$this->carouselPlaces->contains($carouselPlace)) {
            $this->carouselPlaces[] = $carouselPlace;
            $carouselPlace->addCarousel($this);
        }
        return $this;
    }

    public function removeCarouselPlace(CarouselPlace $carouselPlace): self
    {
        if ($this->carouselPlaces->removeElement($carouselPlace)) {
            $carouselPlace->removeCarousel($this);
        }

        return $this;
    }


    public function __toString()
    {
        return $this->getName();
    }
}
