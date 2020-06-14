<?php
declare(strict_types=1);

namespace test\edwrodrig\mypage\ws;

use labo86\exception_with_data\ExceptionWithData;
use labo86\hapi_core\Request;
use labo86\hapi_core\ResponseJson;
use edwrodrig\mypage\ws\Controller;
use PHPUnit\Framework\TestCase;

class ControllerTest extends TestCase
{
    /**
     * @throws ExceptionWithData
     */
    public function testBasic() {
        $controller = new Controller();

        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getParams'])
            ->getMock();

        $request->expects($this->any())
            ->method('getParams')
            ->willReturn(['a' => 2 , 'b' => 2]);

        $service = $controller->getServiceMap()->getService('sum');
        $response = $service($request);

        $this->assertInstanceOf(ResponseJson::class, $response);

    }
}
