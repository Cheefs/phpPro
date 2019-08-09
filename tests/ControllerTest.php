<?php

namespace app\tests;

use app\services\interfaces\IRenderService;
use app\services\Request;
use app\services\TwigRenderService;
use PHPUnit\Framework\TestCase;

class ControllerTest extends TestCase {

    public $controller;

    public function testRenderer() {
        $renderer = new TwigRenderService();
        $this->assertInstanceOf(IRenderService::class, $renderer);
        $this->assertIsObject($renderer);
        return $renderer;
    }

    public function testRequest() {
        $request = new Request();
        $this->assertIsObject($request);
        return $request;
    }

    /**
     *
     * @dataProvider runProvider
    */
    public function testRun(string $action = null, int $id = null) {
        if ($action) {
            $this->assertNotNull($action);
            $action = 'action'.ucfirst($action);

            $this->assertTrue(method_exists($this, $action));
        }
    }

    public function runProvider() {
        return [
            ['index' ],
            ['create', 1],
        ];
    }

    public function getControllerName() {
        $className = self::class;
        $folder = str_replace(CONTROLLER,'', $className);
        $this->assertNotNull($folder);
        $this->assertIsString($folder);
        return strtolower($folder);
    }

    public function additionProvider() {
        return [
            ['index', ['1' => 1 ] ],
            ['create', []],
        ];
    }

}