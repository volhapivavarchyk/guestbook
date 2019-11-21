<?php
declare(strict_types=1);

namespace Piv\Guestbook\DataFixtures;

use Piv\Guestbook\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends DataFixtures
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
          $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
          $user = new User();

          $user->setPassword(
              $this->passwordEncoder->encodePassword(
                  $user,
                  'the_new_password'
          ));
    }
}
