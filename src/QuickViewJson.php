<?php

namespace OlegGanshonkov\QuickView;

use OlegGanshonkov\QuickView\Interfaces\JsonFormatterInterface;

class QuickViewJson implements JsonFormatterInterface
{
    public function format(string $data, bool $isTerminal = false): string
    {
        $arr = json_decode($data, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Invalid JSON data');
        }
        $str = json_encode($arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return $isTerminal ? $this->colorizeJson($str) : $this->formatJsonForHtml($str);
    }

    private function colorizeJson($jsonString)
    {
        $ansiColors = [
            'KEY' => "\033[36m",
            'STRING' => "\033[32m",
            'NUMBER' => "\033[33m",
            'BOOLEAN' => "\033[35m",
            'NULL' => "\033[31m",
            'RESET' => "\033[0m",
        ];

        $patterns = [
            '/"(.*?)":/' => 'yyyyy$1jjjjj',
            '/"(.*?)"/' => $ansiColors['STRING'] . '$0' . $ansiColors['RESET'],
            '/\b(true|false)\b/' => $ansiColors['BOOLEAN'] . '$0' . $ansiColors['RESET'],
            '/\b(null)\b/' => $ansiColors['NULL'] . '$0' . $ansiColors['RESET'],
            '/\b\d+(\.\d+)?\b/' => $ansiColors['NUMBER'] . '$0' . $ansiColors['RESET'],
        ];

        foreach ($patterns as $pattern => $replacement) {
            $jsonString = preg_replace($pattern, $replacement, $jsonString);
        }
        $jsonString = str_replace('yyyyy', $ansiColors['KEY'], $jsonString);
        $jsonString = str_replace('jjjjj', $ansiColors['RESET'] . ':', $jsonString);

        return $jsonString;
    }

    private function formatJsonForHtml($jsonString)
    {
        $patterns = [
            '/"(.*?)":/' => 'yyyyy$1jjjjj',
            '/"([^"]*)"(?!:)/' => '<span class="json-string">$0</span>',
            '/\b(true|false)\b/' => '<span class="json-boolean">$0</span>',
            '/\b(null)\b/' => '<span class="json-null">$0</span>',
            '/\b\d+(\.\d+)?\b/' => '<span class="json-number">$0</span>',
        ];

        foreach ($patterns as $pattern => $replacement) {
            $jsonString = preg_replace($pattern, $replacement, $jsonString);
        }
        $jsonString = str_replace('yyyyy', '<span class="json-key">"', $jsonString);
        $jsonString = str_replace('jjjjj', '"</span>:', $jsonString);

        $style = '
        <style>
            .json-output {
                background: #2d2d2d;
                color: #f8f8f8;
                padding: 10px;
                border-radius: 5px;
                font-family: monospace;
            }
            .json-key {
                color: #66d9ef;
            }
            .json-string {
                color: #a6e22e;
            }
            .json-number {
                color: #fd971f;
            }
            .json-boolean {
                color: #ac80ff;
            }
            .json-null {
                color: #f92672;
            }
        </style>
        ';

        return $style . '<pre class="json-output">' . $jsonString . '</pre>';
    }
}
