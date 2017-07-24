<?php


namespace RstGroup\ZfLocalConfigModule\Tests\Controller;


use RstGroup\ZfLocalConfigModule\Controller\LocalConfigController;
use PHPUnit\Framework\TestCase;
use RstGroup\ZfLocalConfigModule\Tests\Dummies\DummyConfigWriter;
use Zend\Config\Reader\ReaderInterface;
use Zend\Console\Request;
use Zend\Console\Response;

class LocalConfigControllerTest extends TestCase
{
    public function testItCanSetScalarValueAtGivenPath()
    {
        // given: mocked config reader
        $reader = $this->getMockBuilder(ReaderInterface::class)->getMock();
        $reader->method('fromFile')->willReturn([]);
        // given: mocked config writer
        $writer = new DummyConfigWriter();

        // given: controller itself
        $controller = new LocalConfigController('some-example-file.php', $writer, $reader);

        // given: dispatch controller
        try {
            $controller->dispatch(new Request([
                'public/index.php', 'local-config', 'set', 'path' => 'path.in.config', 'value' => 'scalar-value'
            ]), new Response());
        } catch (\Exception $exception) {}

        // when
        $controller->setAction();

        // then
        $this->assertSame(
            [
                'path' => [ 'in' => [ 'config' => 'scalar-value' ]]
            ],
            $writer->getLastWrittenConfig()->toArray()
        );
    }

    public function testItCanSetStructureAtGivenPathUsingJsonNotation()
    {
        // given: mocked config reader
        $reader = $this->getMockBuilder(ReaderInterface::class)->getMock();
        $reader->method('fromFile')->willReturn([]);
        // given: mocked config writer
        $writer = new DummyConfigWriter();

        // given: controller itself
        $controller = new LocalConfigController('some-example-file.php', $writer, $reader);

        // given: dispatch controller
        try {
            $controller->dispatch(new Request([
                'public/index.php', 'local-config', 'set', 'path' => 'path.in.config', 'value' => '{"another":{"items":[1,2,3]}}', 'json' => true
            ]), new Response());
        } catch (\Exception $exception) {}

        // when
        $controller->setAction();

        // then
        $this->assertSame(
            [
                'path' => [ 'in' => [ 'config' => [
                    'another' => ['items' => [1,2,3]]
                ] ]]
            ],
            $writer->getLastWrittenConfig()->toArray()
        );
    }
}
