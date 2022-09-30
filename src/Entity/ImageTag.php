<?php

namespace App\Entity;

use App\Repository\ImageTagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageTagRepository::class)
 */
class ImageTag
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
    private $tagName;

    /**
     * @ORM\OneToMany(targetEntity=Carousel::class, mappedBy="tag")
     */
    private $carousels;

    public function __construct()
    {
        $this->carousels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTagName(): ?string
    {
        return $this->tagName;
    }

    public function setTagName(?string $tagName): self
    {
        $this->tagName = $tagName;

        return $this;
    }

    /**
     * @return Collection<int, Carousel>
     */
    public function getCarousels(): Collection
    {
        return $this->carousels;
    }

    public function addCarousel(Carousel $carousel): self
    {
        if (!$this->carousels->contains($carousel)) {
            $this->carousels[] = $carousel;
            $carousel->setTag($this);
        }

        return $this;
    }

    public function removeCarousel(Carousel $carousel): self
    {
        if ($this->carousels->removeElement($carousel)) {
            // set the owning side to null (unless already changed)
            if ($carousel->getTag() === $this) {
                $carousel->setTag(null);
            }
        }

        return $this;
    }
}
