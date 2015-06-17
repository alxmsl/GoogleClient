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

namespace alxmsl\Test\Google\GCM;

use alxmsl\Google\GCM\Message\SyncMessage;
use PHPUnit_Framework_TestCase;

/**
 * Sync message payload test class
 * @author alxmsl
 */
final class SyncMessageTest extends PHPUnit_Framework_TestCase {
    public function testInitialState() {
        $Message = new SyncMessage();
        $this->assertEmpty($Message->getCollapseKey());
        $this->assertEquals([
            'collapse_key'     => '',
            'delay_while_idle' => false,
            'dry_run'          => false,
        ], $Message->export());
    }

    public function testProperties() {
        $Message = new SyncMessage();
        $Message->setCollapseKey('COLlapse');
        $this->assertEquals('COLlapse', $Message->getCollapseKey());
        $this->assertEquals([
            'collapse_key'     => 'COLlapse',
            'delay_while_idle' => false,
            'dry_run'          => false,
        ], $Message->export());
    }
}
