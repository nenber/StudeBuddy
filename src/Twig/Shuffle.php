<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class Shuffle extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('shuffle', [$this, 'shuffleMatching']),
        ];
    }

    public function shuffleMatching(array $arrayUsers): array
    {
        shuffle($arrayUsers);
        return $arrayUsers;
    }
}