<?php

namespace App\Entity;

use App\Repository\CommentBlogRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentBlogRepository::class)]
class CommentBlog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("commentBlog_list")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $comment = null;

    #[ORM\ManyToOne(inversedBy: 'commentBlogs')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'commentBlogs')]
    private ?Blog $blog = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getBlog(): ?Blog
    {
        return $this->blog;
    }

    public function setBlog(?Blog $blog): self
    {
        $this->blog = $blog;

        return $this;
    }
}
