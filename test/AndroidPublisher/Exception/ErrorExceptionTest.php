<?php
/*
 * Copyright 2015 Alexey Maslov <alexey.y.maslov@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace alxmsl\Test\Google\AndroidPublisher;

use alxmsl\Google\AndroidPublisher\Exception\ErrorException;
use alxmsl\Google\AndroidPublisher\Exception\InvalidCredentialsException;
use alxmsl\Google\AndroidPublisher\Exception\NotFoundException;
use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * Error exception class tests
 * @author alxmsl
 */
final class ErrorExceptionTest extends PHPUnit_Framework_TestCase {
    public function testInitialState() {
        $Error = new ErrorException();
        $this->assertEquals([], $Error->getErrors());
    }

    public function testErrorException() {
        $Exception1 = ErrorException::initializeByString('{
 "error": {
  "errors": [
   {
    "domain": "global",
    "reason": "invalid",
    "message": "Invalid Value"
   }
  ],
  "code": 400,
  "message": "Invalid Value"
 }
}');
        $this->assertInstanceOf(ErrorException::class, $Exception1);
        $this->assertCount(1, $Exception1->getErrors());
        $this->assertInstanceOf(stdClass::class, $Exception1->getErrors()[0]);
        $this->assertEquals('400', $Exception1->getCode());
        $this->assertEquals('Invalid Value', $Exception1->getMessage());

        $Error1 = $Exception1->getErrors()[0];
        $this->assertObjectHasAttribute('domain', $Error1);
        $this->assertObjectHasAttribute('reason', $Error1);
        $this->assertObjectHasAttribute('message', $Error1);
        $this->assertEquals('global', $Error1->domain);
        $this->assertEquals('Invalid Value', $Error1->message);
        $this->assertEquals('invalid', $Error1->reason);

        $Exception2 = ErrorException::initializeByString('{
 "error": {
  "errors": [
   {
    "domain": "androidpublisher",
    "reason": "purchaseTokenDoesNotMatchProductId",
    "message": "The purchase token does not match the product ID.",
    "locationType": "parameter",
    "location": "token"
   }
  ],
  "code": 400,
  "message": "The purchase token does not match the product ID."
 }
}');
        $this->assertInstanceOf(ErrorException::class, $Exception2);
        $this->assertCount(1, $Exception2->getErrors());
        $this->assertInstanceOf(stdClass::class, $Exception2->getErrors()[0]);
        $this->assertEquals('400', $Exception2->getCode());
        $this->assertEquals('The purchase token does not match the product ID.', $Exception2->getMessage());

        $Error2 = $Exception2->getErrors()[0];
        $this->assertObjectHasAttribute('domain', $Error2);
        $this->assertObjectHasAttribute('location', $Error2);
        $this->assertObjectHasAttribute('locationType', $Error2);
        $this->assertObjectHasAttribute('reason', $Error2);
        $this->assertObjectHasAttribute('message', $Error2);
        $this->assertEquals('androidpublisher', $Error2->domain);
        $this->assertEquals('token', $Error2->location);
        $this->assertEquals('parameter', $Error2->locationType);
        $this->assertEquals('The purchase token does not match the product ID.', $Error2->message);
        $this->assertEquals('purchaseTokenDoesNotMatchProductId', $Error2->reason);
    }

    public function testInheritedExceptions() {
        $Exception1 = InvalidCredentialsException::initializeByString('{
 "error": {
  "errors": [
   {
    "domain": "global",
    "reason": "authError",
    "message": "Invalid Credentials",
    "locationType": "header",
    "location": "Authorization"
   }
  ],
  "code": 401,
  "message": "Invalid Credentials"
 }
}');
        $this->assertInstanceOf(InvalidCredentialsException::class, $Exception1);
        $this->assertCount(1, $Exception1->getErrors());
        $this->assertInstanceOf(stdClass::class, $Exception1->getErrors()[0]);
        $this->assertEquals('401', $Exception1->getCode());
        $this->assertEquals('Invalid Credentials', $Exception1->getMessage());

        $Error1 = $Exception1->getErrors()[0];
        $this->assertObjectHasAttribute('domain', $Error1);
        $this->assertObjectHasAttribute('location', $Error1);
        $this->assertObjectHasAttribute('locationType', $Error1);
        $this->assertObjectHasAttribute('message', $Error1);
        $this->assertObjectHasAttribute('reason', $Error1);
        $this->assertEquals('global', $Error1->domain);
        $this->assertEquals('Authorization', $Error1->location);
        $this->assertEquals('header', $Error1->locationType);
        $this->assertEquals('Invalid Credentials', $Error1->message);
        $this->assertEquals('authError', $Error1->reason);

        $Exception2 = NotFoundException::initializeByString('{
 "error": {
  "errors": [
   {
    "domain": "global",
    "reason": "applicationNotFound",
    "message": "No application was found for the given package name.",
    "locationType": "parameter",
    "location": "packageName"
   }
  ],
  "code": 404,
  "message": "No application was found for the given package name."
 }
}');
        $this->assertInstanceOf(NotFoundException::class, $Exception2);
        $this->assertCount(1, $Exception2->getErrors());
        $this->assertInstanceOf(stdClass::class, $Exception2->getErrors()[0]);
        $this->assertEquals('404', $Exception2->getCode());
        $this->assertEquals('No application was found for the given package name.', $Exception2->getMessage());

        $Error2 = $Exception2->getErrors()[0];
        $this->assertObjectHasAttribute('domain', $Error2);
        $this->assertObjectHasAttribute('location', $Error2);
        $this->assertObjectHasAttribute('locationType', $Error2);
        $this->assertObjectHasAttribute('reason', $Error2);
        $this->assertObjectHasAttribute('message', $Error2);
        $this->assertEquals('global', $Error2->domain);
        $this->assertEquals('packageName', $Error2->location);
        $this->assertEquals('parameter', $Error2->locationType);
        $this->assertEquals('No application was found for the given package name.', $Error2->message);
        $this->assertEquals('applicationNotFound', $Error2->reason);

        $Exception3 = NotFoundException::initializeByString('Not Found');
        $this->assertInstanceOf(NotFoundException::class, $Exception3);
        $this->assertCount(0, $Exception3->getErrors());
        $this->assertEquals('0', $Exception3->getCode());
        $this->assertEquals('Not Found', $Exception3->getMessage());

        $Exception3 = NotFoundException::initializeByString('{
 "error": {
  "errors": [
   {
    "domain": "global",
    "reason": "purchaseTokenNotFound",
    "message": "The purchase token was not found.",
    "locationType": "parameter",
    "location": "token"
   }
  ],
  "code": 404,
  "message": "The purchase token was not found."
 }
}');
        $this->assertInstanceOf(NotFoundException::class, $Exception3);
        $this->assertCount(1, $Exception3->getErrors());
        $this->assertInstanceOf(stdClass::class, $Exception3->getErrors()[0]);
        $this->assertEquals('404', $Exception3->getCode());
        $this->assertEquals('The purchase token was not found.', $Exception3->getMessage());

        $Error3 = $Exception3->getErrors()[0];
        $this->assertObjectHasAttribute('domain', $Error3);
        $this->assertObjectHasAttribute('location', $Error3);
        $this->assertObjectHasAttribute('locationType', $Error3);
        $this->assertObjectHasAttribute('reason', $Error3);
        $this->assertObjectHasAttribute('message', $Error3);
        $this->assertEquals('global', $Error3->domain);
        $this->assertEquals('token', $Error3->location);
        $this->assertEquals('parameter', $Error3->locationType);
        $this->assertEquals('The purchase token was not found.', $Error3->message);
        $this->assertEquals('purchaseTokenNotFound', $Error3->reason);

        $Exception3 = NotFoundException::initializeByString('Not Found');
        $this->assertInstanceOf(NotFoundException::class, $Exception3);
        $this->assertCount(0, $Exception3->getErrors());
        $this->assertEquals('0', $Exception3->getCode());
        $this->assertEquals('Not Found', $Exception3->getMessage());
    }
}
