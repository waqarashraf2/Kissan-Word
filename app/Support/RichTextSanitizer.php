<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;

class RichTextSanitizer
{
    private const ALLOWED_TAGS = [
        'p', 'br', 'strong', 'b', 'em', 'i', 'u', 's', 'h2', 'h3', 'h4',
        'ul', 'ol', 'li', 'blockquote', 'a', 'hr',
    ];

    public function sanitize(?string $html): ?string
    {
        if (blank($html)) {
            return null;
        }

        $document = new DOMDocument('1.0', 'UTF-8');
        $previous = libxml_use_internal_errors(true);
        $document->loadHTML(
            '<?xml encoding="UTF-8"><div id="rich-text-root">'.$html.'</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $root = $document->getElementById('rich-text-root');
        if (! $root) {
            return null;
        }

        $this->cleanChildren($root);

        $clean = '';
        foreach ($root->childNodes as $child) {
            $clean .= $document->saveHTML($child);
        }

        return trim($clean) ?: null;
    }

    private function cleanChildren(DOMNode $parent): void
    {
        foreach (iterator_to_array($parent->childNodes) as $node) {
            if ($node instanceof DOMElement) {
                $tag = strtolower($node->tagName);

                if (! in_array($tag, self::ALLOWED_TAGS, true)) {
                    $this->unwrap($node);

                    continue;
                }

                foreach (iterator_to_array($node->attributes) as $attribute) {
                    if ($tag !== 'a' || ! in_array(strtolower($attribute->name), ['href', 'title'], true)) {
                        $node->removeAttribute($attribute->name);
                    }
                }

                if ($tag === 'a') {
                    $href = trim($node->getAttribute('href'));
                    if (! preg_match('/^(https?:\/\/|mailto:|tel:|\/|#)/i', $href)) {
                        $node->removeAttribute('href');
                    } else {
                        $node->setAttribute('rel', 'nofollow noopener');
                    }
                }
            }

            $this->cleanChildren($node);
        }
    }

    private function unwrap(DOMElement $element): void
    {
        $parent = $element->parentNode;
        if (! $parent) {
            return;
        }

        while ($element->firstChild) {
            $parent->insertBefore($element->firstChild, $element);
        }

        $parent->removeChild($element);
    }
}
