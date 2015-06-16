<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
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
