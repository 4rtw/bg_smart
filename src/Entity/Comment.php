<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommentRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 * @ApiResource(
 *   attributes={
 *      "order"={"createdAt":"DESC"}
 *   },
 *   normalizationContext={"groups"={"read:comment"}},
 *   collectionOperations={
 *   "get",
 *   "post"={
 *      "security"="is_granted('IS_AUTHENTICATED_FULLY')",
 *      "controller"=App\Controller\Api\CommentController::class,
 *      "denormalization_context"={"groups"={"create:comment"}}
 *   }
 *   },
 *   itemOperations={
 *     "get"={
 *      "normalization_context"={"groups"={"read:comment","read:full:comment"}}
 *      },
 *      "put"={
 *          "security"="is_granted('EDIT_COMMENT',object)",
 *          "denormalization_context"={"groups"={"update:comment"}}
 *      },
 *      "delete"={
 *          "security"="is_granted('EDIT_COMMENT',object)",
 *      }
 *   },
 *   paginationItemsPerPage=2
 * )
 * 
 * @ApiFilter(SearchFilter::class, properties={"post":"exact"})
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:comment"})
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Groups({"read:comment","create:comment","update:comment"})
     */
    private $content; 

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="comments",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read:full:comment","create:comment"})
     */
    private $post;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Groups({"read:comment"})
     */
    private $author;

    /**
     * @ORM\Column(type="datetime_immutable")
     * 
     * @Groups({"read:comment"})
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
