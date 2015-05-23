<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace alxmsl\Google\GCM\Message;

/**
 * Class for user-defined payloads
 * @author alxmsl
 */
final class CustomPayloadData extends PayloadData {
    /**
     * @var array notification payload data
     */
    private $data = [];

    /**
     * @param array $data notification payload data
     */
    public function __construct(array $data) {
        $this->data = $data;
    }

    /**
     * @inheritdoc
     */
    protected function getDataFields() {
        return $this->data;
    }
}
