<?php

function toJSON($o)
{
    switch (gettype($o)) {
        case 'NULL':
            return 'null';
        case 'integer':
        case 'double':
            return strval($o);
        case 'string':
            return '"' . addslashes($o) . '"';
        case 'boolean':
            return $o ? 'true' : 'false';
        case 'object':
            $o = (array)$o;
        case 'array':
            $foundKeys = false;

            foreach ($o as $k => $v) {
                if (!is_numeric($k)) {
                    $foundKeys = true;
                    break;
                }
            }

            $result = array();

            if ($foundKeys) {
                foreach ($o as $k => $v) {
                    $result [] = toJSON($k) . ':' . toJSON($v);
                }

                return '{' . implode(',', $result) . '}';
            } else {
                foreach ($o as $k => $v) {
                    $result [] = toJSON($v);
                }
                return '[' . implode(',', $result) . ']';
            }
    }
}