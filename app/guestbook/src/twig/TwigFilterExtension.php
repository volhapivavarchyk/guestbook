<?php
declare(strict_types=1);

namespace Piv\Guestbook\Src\Twig;

use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;
use Piv\Guestbook\Src\Entities\Message;
use Piv\Guestbook\Src\Entities\User;

class TwigFilterExtension extends AbstractExtension
{
    public function usort(array $array, string $sortFlag): array
    {
        $funcName = 'sort'.$sortFlag;
        return $this->$funcName($array);
    }

    protected function sortByNameAsc(array $array): array
    {
        usort(
            $array,
            function ($object1, $object2) {
                return strcasecmp($object1->getUser()->getName(), $object2->getUser()->getName());
            },
        );
        return $array;
    }

    protected function sortByNameDesc(array $array): array
    {
        usort(
            $array,
            function ($object1, $object2) {
                return strcasecmp($object2->getUser()->getName(), $object1->getUser()->getName());
            },
        );
        return $array;
    }

    protected function sortByEmailAsc(array $array): array
    {
        usort(
            $array,
            function ($object1, $object2) {
                return strcasecmp($object1->getUser()->getEmail(), $object2->getUser()->getEmail());
            },
        );
        return $array;
    }

    protected function sortByEmailDesc(array $array): array
    {
        usort(
            $array,
            function ($object1, $object2) {
                return strcasecmp($object2->getUser()->getEmail(), $object1->getUser()->getEmail());
            },
        );
        return $array;
    }

    protected function sortByDateAsc(array $array): array
    {
        usort(
            $array,
            function ($object1, $object2) {
                return $object1->getDate() <=> $object2->getDate();
            },
        );
        return $array;
    }

    protected function sortByDateDesc(array $array): array
    {
        usort(
            $array,
            function ($object1, $object2) {
                return $object2->getDate() <=> $object1->getDate();
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
