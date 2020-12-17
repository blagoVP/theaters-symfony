<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity("username")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *          min = 3,
     *          max = 20,
     *          minMessage = "Your username must be at least {{ limit }} characters long",
     *          maxMessage = "Your username cannot be longer than {{ limit }} characters"
     * )
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Play::class, mappedBy="usersLiked")
     */
    private $likedPlays;

    /**
     * @ORM\OneToMany(targetEntity=Play::class, mappedBy="creator", orphanRemoval=true)
     */
    private $plays;

    public function __construct()
    {
        $this->plays = new ArrayCollection();
        $this->likedPlays = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection|Play[]
     */
    public function getLikedPlays(): Collection
    {
        return $this->likedPlays;
    }

    public function addLikedPlay(Play $likedPlay): self
    {
        if (!$this->likedPlays->contains($likedPlay)) {
            $this->likedPlays[] = $likedPlay;
            $likedPlay->setUsersLiked($this);
        }

        return $this;
    }

    public function removeLikedPlay(Play $likedPlay): self
    {
        if ($this->likedPlays->removeElement($likedPlay)) {
            // set the owning side to null (unless already changed)
            if ($likedPlay->getUsersLiked() === $this) {
                $likedPlay->setUsersLiked(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Play[]
     */
    public function getPlays(): Collection
    {
        return $this->plays;
    }

    public function addPlay(Play $play): self
    {
        if (!$this->plays->contains($play)) {
            $this->plays[] = $play;
            $play->setCreator($this);
        }

        return $this;
    }

    public function removePlay(Play $play): self
    {
        if ($this->plays->removeElement($play)) {
            // set the owning side to null (unless already changed)
            if ($play->getCreator() === $this) {
                $play->setCreator(null);
            }
        }

        return $this;
    }
}
