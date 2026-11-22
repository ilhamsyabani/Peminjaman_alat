<?php

namespace App\Support;

use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

class PostContentSanitizer
{
    private HtmlSanitizer $sanitizer;

    public function __construct()
    {
        $config = new HtmlSanitizerConfig();

        foreach (['div', 'p', 'br', 'strong', 'em', 'u', 'del', 'h1', 'h2', 'h3',
            'blockquote', 'ul', 'ol', 'li', 'pre', 'code', 'figure', 'figcaption'] as $element) {
            $config = $config->allowElement($element, []);
        }

        $config = $config->allowElement('a', ['href', 'title']);
        $config = $config->allowElement('img', ['src', 'alt', 'width', 'height']);

        $this->sanitizer = new HtmlSanitizer($config);
    }

    public function sanitize(?string $html): string
    {
        return $this->sanitizer->sanitize($html ?? '');
    }
}
