<?php

namespace Wulkanowy\Tests\TimetableParser;

use DOMWrap\Document;
use PHPUnit\Framework\TestCase;
use Wulkanowy\TimetableParser\Table;

class EqualsTest extends TestCase
{
    public function testClass(): void
    {
        $remote = file_get_contents(__DIR__.'/fixtures/oddzial.html');
        $generated = $this->getGeneratedHTML($remote);

        $this->assertEquals($this->format($remote), $this->format($generated));
    }

    public function testRoom(): void
    {
        $remote = file_get_contents(__DIR__.'/fixtures/sala.html');
        $actual = $this->getGeneratedHTML($remote);

        $this->assertEquals($this->format($remote), $this->format($actual));
    }

    private function getGeneratedHTML(string $html): bool|string
    {
        $table = (new Table($html))->getTable();

        ob_start();
        require __DIR__.'/template.html.php';
        $rendered = ob_get_contents();
        ob_end_clean();

        return $rendered;
    }

    private function format($html): string
    {
        $html = preg_replace('/\r\n|\n\r|\n|\r/', '', $html);
        $html = preg_replace('/\s+/', ' ', $html);
        $doc = new Document();
        $doc->html($html);
        $doc->find('.tabela');
        $html = $doc->find('.tabela')->first()->getHtml();

        return str_replace(' ', '', $html);
    }
}
