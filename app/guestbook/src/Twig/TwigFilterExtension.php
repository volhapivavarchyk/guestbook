<?php
declare(strict_types=1);

namespace Piv\Guestbook\Twig;

use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;
use Piv\Guestbook\Entities\Message;
use Piv\Guestbook\Entities\User;

class TwigFilterExtension extends AbstractExtension
{
    public function usort(array $array, string $sortFlag): array
    {
        $funcName = 'sort'.$sortFlag;
        return $this->$funcName($array);
    }

    protected function sortByUsernameAsc(array $array): array
    {
        usort(
            $array,
            function ($object1, $object2) {
                return strcasecmp($object1[0]->getUser()->getUsername(), $object2[0]->getUser()->getUsername());
            },
        );
        return $array;
    }

    protected function sortByUsernameDesc(array $array): array
    {
        usort(
            $array,
            function ($object1, $object2) {
                return strcasecmp($object2[0]->getUser()->getUsername(), $object1[0]->getUser()->getUsername());
            },
        );
        return $array;
    }

    protected function sortByEmailAsc(array $array): array
    {
        usort(
            $array,
            function ($object1, $object2) {
                return strcasecmp($object1[0]->getUser()->getEmail(), $object2[0]->getUser()->getEmail());
            },
        );
        return $array;
    }

    protected function sortByEmailDesc(array $array): array
    {
        usort(
            $array,
            function ($object1, $object2) {
                return strcasecmp($object2[0]->getUser()->getEmail(), $object1[0]->getUser()->getEmail());
            },
        );
        return $array;
    }

    protected function sortByDateAsc(array $array): array
    {
        usort(
            $array,
            function ($object1, $object2) {
                return $object1[0]->getDate() <=> $object2[0]->getDate();
            },
        );
        return $array;
    }

    protected function sortByDateDesc(array $array): array
    {
        usort(
            $array,
            function ($object1, $object2) {
                return $object2[0]->getDate() <=> $object1[0]->getDate();
            },
        );
        return $array;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('usort', [$this, 'usort']),
        ];
    }
}
