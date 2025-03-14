<?php

namespace OlegGanshonkov\QuickView\Interfaces;

interface JsonFormatterInterface
{
    public function format(string $data, bool $isTerminal = false): string;
}

