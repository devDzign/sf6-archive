<?php

namespace App\Twig;

use Symfony\Component\Serializer\SerializerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class SerializeExtension extends AbstractExtension
{
    /**
     * SerializeExtension constructor.
     *
     * @param SerializerInterface $serializer
     */
    public function __construct(private SerializerInterface $serializer)
    {
    }

    /**
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('serialize', [$this, 'serialize']),
        ];
    }

    /**
     * @param        $data
     *
     */
    public function serialize($data, string $format = 'json', array $context = []): string
    {
        return $this->serializer->serialize($data, $format, $context);
    }
}
