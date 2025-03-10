<?php

namespace OlegGanshonkov\QuickView;

class QuickView
{
    public function ul(array $data): string
    {
        $result = '<ul class="quick-view">';
        foreach ($data as $item) {
            $result .= '<li>' . $item . '</li>';
        }
        $result .= '</ul>';
        return $result;
    }

    public static function json(string $data, bool $isTerminal = false): string
    {
        return (new QuickViewJson())->json($data, $isTerminal);
    }

}
