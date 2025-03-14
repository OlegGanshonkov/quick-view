<?php

namespace OlegGanshonkov\QuickView;

use OlegGanshonkov\QuickView\Interfaces\UlGeneratorInterface;

class QuickViewUl implements UlGeneratorInterface
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

}
