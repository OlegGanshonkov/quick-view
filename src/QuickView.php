<?php

namespace OlegGanshonkov\QuickView;

use OlegGanshonkov\QuickView\Interfaces\UlGeneratorInterface;
use OlegGanshonkov\QuickView\Interfaces\JsonFormatterInterface;

class QuickView
{
    private $ulGenerator;
    private $jsonFormatter;

    public function __construct(
        UlGeneratorInterface $ulGenerator = null,
        JsonFormatterInterface $jsonFormatter = null
    ) {
        $this->ulGenerator = $htmlGenerator ?? new QuickViewUl();
        $this->jsonFormatter = $jsonFormatter ?? new QuickViewJson();
    }

    public function ul(array $data): string
    {
        return $this->ulGenerator->ul($data);
    }

    public function json(string $data, bool $isTerminal = false): string
    {
        return $this->jsonFormatter->format($data, $isTerminal);
    }

}

