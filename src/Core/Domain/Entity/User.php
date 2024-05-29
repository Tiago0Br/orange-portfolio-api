<?php

declare(strict_types=1);

namespace OrangePortfolio\Core\Domain\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use OrangePortfolio\Core\Domain\Dto\RegisterUserDto;

#[ORM\Table(name: 'users')]
#[ORM\Entity]
class User
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(name: 'name', type: Types::STRING)]
    private string $name;

    #[ORM\Column(name: 'email', type: Types::STRING, unique: true)]
    private string $email;

    #[ORM\Column(name: 'password', type: Types::STRING)]
    private string $password;

    #[ORM\OneToOne(targetEntity: Image::class, cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'selfie_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Image $selfie;

    public function getId(): int
    {
        return $this->id;
    }

    public function validatePassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'selfie' => $this->selfie->jsonSerialize(),
        ];
    }

    public static function create(
        RegisterUserDto $userDto,
        Image $selfie
    ): self {
        $user = new self();
        $user->name = $userDto->name;
        $user->email = $userDto->email;
        $user->password = password_hash($userDto->password, PASSWORD_BCRYPT);
        $user->selfie = $selfie;

        return $user;
    }
}