<?php
namespace App\Controller\Api;

use App\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;

class CommentController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security=$security;
    }

    public function __invoke(Comment $data)
    {
        $data->setAuthor($this->security->getUser());
        $data->setCreatedAt(new \DateTimeImmutable('now'));
        return $data;
    }
}