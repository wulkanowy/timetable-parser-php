<?php

namespace Wulkanowy\Tests\TimetableParser;

use PHPUnit\Framework\TestCase;
use Wulkanowy\TimetableParser\Table;

class TableTest extends TestCase
{
    private Table $table;

    private Table $tableRoom;

    public function setUp(): void
    {
        $this->table = new Table(file_get_contents(__DIR__.'/fixtures/oddzial.html'));
        $this->tableRoom = new Table(file_get_contents(__DIR__.'/fixtures/sala.html'));
    }

    public function testGetTable(): void
    {
        $this->assertCount(5, $this->table->getTable()['days']);
        $this->assertCount(10, $this->table->getTable()['days'][2]['hours']);
    }

    public function testGetTableName(): void
    {
        $this->assertEquals('3Ti', $this->table->getTable()['name']);
        $this->assertEquals('21 prac. historii', $this->tableRoom->getTable()['name']);
    }

    public function testGetTableTypeName(): void
    {
        $this->assertEquals('oddziału', $this->table->getTable()['typeName']);
        $this->assertEquals('sali', $this->tableRoom->getTable()['typeName']);
    }

    public function testGetTableGenerated(): void
    {
        $this->assertEquals('17.02.2018', $this->table->getTable()['generated']);
        $this->assertEquals('17.02.2018', $this->tableRoom->getTable()['generated']);
    }

    public function testGetTableDescription(): void
    {
        $this->assertEquals('Obowiązuje od: 19 lutego 2018r.', $this->table->getTable()['description']);
        $this->assertEquals('Obowiązuje od: 19 lutego 2018r.', $this->tableRoom->getTable()['description']);
    }

    public function testGetTableDays(): void
    {
        $this->assertEquals('Poniedziałek', $this->table->getTable()['days'][0]['name']);
        $this->assertEquals('Piątek', $this->table->getTable()['days'][4]['name']);
    }

    public function testGetTableHoursSize(): void
    {
        $this->assertCount(0, $this->table->getTable()['days'][1]['hours'][0]['lessons']);
        $this->assertCount(1, $this->table->getTable()['days'][1]['hours'][4]['lessons']);
        $this->assertCount(2, $this->table->getTable()['days'][2]['hours'][3]['lessons']);
        $this->assertCount(2, $this->table->getTable()['days'][4]['hours'][7]['lessons']);
    }

    public function testGetTableHoursNumber(): void
    {
        $this->assertEquals('1', $this->table->getTable()['days'][0]['hours'][0]['number']);
        $this->assertEquals('3', $this->table->getTable()['days'][1]['hours'][2]['number']);
        $this->assertEquals('5', $this->table->getTable()['days'][2]['hours'][4]['number']);
        $this->assertEquals('7', $this->table->getTable()['days'][3]['hours'][6]['number']);
        $this->assertEquals('9', $this->table->getTable()['days'][4]['hours'][8]['number']);
    }

    public function testGetTableHoursStart(): void
    {
        $this->assertEquals('8:00', $this->table->getTable()['days'][0]['hours'][0]['start']);
        $this->assertEquals('9:40', $this->table->getTable()['days'][1]['hours'][2]['start']);
        $this->assertEquals('11:30', $this->table->getTable()['days'][2]['hours'][4]['start']);
        $this->assertEquals('13:10', $this->table->getTable()['days'][3]['hours'][6]['start']);
        $this->assertEquals('14:50', $this->table->getTable()['days'][4]['hours'][8]['start']);
    }

    public function testGetTableHoursEnd(): void
    {
        $this->assertEquals('8:45', $this->table->getTable()['days'][0]['hours'][0]['end']);
        $this->assertEquals('10:25', $this->table->getTable()['days'][1]['hours'][2]['end']);
        $this->assertEquals('12:15', $this->table->getTable()['days'][2]['hours'][4]['end']);
        $this->assertEquals('13:55', $this->table->getTable()['days'][3]['hours'][6]['end']);
        $this->assertEquals('15:35', $this->table->getTable()['days'][4]['hours'][8]['end']);
    }

    public function testGetTableLessonTeacherName(): void
    {
        $this->assertEquals('Dr', $this->table->getTable()['days'][0]['hours'][0]['lessons'][0]['teacher']['name']);
        $this->assertEquals('ZJ', $this->table->getTable()['days'][0]['hours'][4]['lessons'][0]['teacher']['name']);
        $this->assertEquals('Dr', $this->table->getTable()['days'][1]['hours'][8]['lessons'][0]['teacher']['name']);
        $this->assertEquals('', $this->table->getTable()['days'][1]['hours'][8]['lessons'][1]['teacher']['name']);
        $this->assertEquals('', $this->table->getTable()['days'][3]['hours'][9]['lessons'][1]['teacher']['name']);
    }

    public function testGetTableLessonTeacherValue(): void
    {
        $this->assertEquals('14', $this->table->getTable()['days'][0]['hours'][0]['lessons'][0]['teacher']['value']);
        $this->assertEquals('67', $this->table->getTable()['days'][0]['hours'][4]['lessons'][0]['teacher']['value']);
        $this->assertEquals('14', $this->table->getTable()['days'][1]['hours'][8]['lessons'][0]['teacher']['value']);
        $this->assertEquals('', $this->table->getTable()['days'][1]['hours'][8]['lessons'][1]['teacher']['value']);
        $this->assertEquals('', $this->table->getTable()['days'][3]['hours'][9]['lessons'][1]['teacher']['value']);
    }

    public function testGetTableLessonRoomName(): void
    {
        $this->assertEquals('35', $this->table->getTable()['days'][0]['hours'][0]['lessons'][0]['room']['name']);
        $this->assertEquals('21', $this->table->getTable()['days'][0]['hours'][4]['lessons'][0]['room']['name']);
        $this->assertEquals('35', $this->table->getTable()['days'][1]['hours'][8]['lessons'][0]['room']['name']);
        $this->assertEquals('19', $this->table->getTable()['days'][1]['hours'][8]['lessons'][1]['room']['name']);
        $this->assertEquals('33', $this->table->getTable()['days'][3]['hours'][9]['lessons'][1]['room']['name']);
    }

    public function testGetTableLessonRoomValue(): void
    {
        $this->assertEquals('13', $this->table->getTable()['days'][0]['hours'][0]['lessons'][0]['room']['value']);
        $this->assertEquals('4', $this->table->getTable()['days'][0]['hours'][4]['lessons'][0]['room']['value']);
        $this->assertEquals('13', $this->table->getTable()['days'][1]['hours'][8]['lessons'][0]['room']['value']);
        $this->assertEquals('3', $this->table->getTable()['days'][1]['hours'][8]['lessons'][1]['room']['value']);
        $this->assertEquals('11', $this->table->getTable()['days'][3]['hours'][9]['lessons'][1]['room']['value']);
        $this->assertEquals('', $this->table->getTable()['days'][4]['hours'][9]['lessons'][0]['room']['value']);
    }

    public function testGetTableLessonSubject(): void
    {
        $this->assertEquals('sieci.komput-2/2', $this->table->getTable()['days'][0]['hours'][0]['lessons'][0]['subject']);
        $this->assertEquals('j.polski', $this->table->getTable()['days'][0]['hours'][4]['lessons'][0]['subject']);
        $this->assertEquals('sieci.komput-1/2', $this->table->getTable()['days'][1]['hours'][8]['lessons'][0]['subject']);
        $this->assertEquals('r_fizyka-2/2 #3fi', $this->table->getTable()['days'][1]['hours'][8]['lessons'][1]['subject']);
        $this->assertEquals('r_informat.-3/3 #2in', $this->table->getTable()['days'][3]['hours'][9]['lessons'][1]['subject']);
        $this->assertEquals('', $this->table->getTable()['days'][4]['hours'][9]['lessons'][0]['subject']);
    }

    public function testGetTableLessonClassName(): void
    {
        $this->assertEquals('', $this->table->getTable()['days'][3]['hours'][9]['lessons'][1]['className']['name']);
        $this->assertEquals('4Tm', $this->tableRoom->getTable()['days'][0]['hours'][0]['lessons'][0]['className']['name']);
        $this->assertEquals('4Tp', $this->tableRoom->getTable()['days'][1]['hours'][0]['lessons'][0]['className']['name']);

        $this->assertIsArray($this->tableRoom->getTable()['days'][3]['hours'][0]['lessons'][0]['className']);
        $this->assertEquals('3Tk', $this->tableRoom->getTable()['days'][3]['hours'][0]['lessons'][0]['className'][0]['name']);
        $this->assertEquals('3Te', $this->tableRoom->getTable()['days'][3]['hours'][0]['lessons'][0]['className'][2]['name']);
    }

    public function testGetTableLessonClassValue(): void
    {
        $this->assertEquals('', $this->table->getTable()['days'][3]['hours'][9]['lessons'][1]['className']['value']);
        $this->assertEquals('28', $this->tableRoom->getTable()['days'][0]['hours'][0]['lessons'][0]['className']['value']);
        $this->assertEquals('29', $this->tableRoom->getTable()['days'][1]['hours'][0]['lessons'][0]['className']['value']);

        $this->assertEquals('20', $this->tableRoom->getTable()['days'][3]['hours'][0]['lessons'][0]['className'][0]['value']);
        $this->assertEquals('18', $this->tableRoom->getTable()['days'][3]['hours'][0]['lessons'][0]['className'][2]['value']);
    }

    public function testGetTableLessonClassAlt(): void
    {
        $this->assertEquals('', $this->table->getTable()['days'][0]['hours'][0]['lessons'][0]['alt']);
        $this->assertEquals('-2/3', $this->tableRoom->getTable()['days'][1]['hours'][0]['lessons'][0]['alt']);
        $this->assertEquals('-3/3', $this->table->getTable()['days'][3]['hours'][9]['lessons'][1]['alt']);
        $this->assertEquals('Zajęcia dodatkowe', $this->table->getTable()['days'][4]['hours'][9]['lessons'][0]['alt']);

        $this->assertFalse(isset($this->tableRoom->getTable()['days'][3]['hours'][0]['lessons'][0]['alt']));
        $this->assertEquals('-3/3', $this->tableRoom->getTable()['days'][3]['hours'][0]['lessons'][0]['className'][0]['alt']);
    }
}
