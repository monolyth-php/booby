<?php

use Monolyth\Booby\Flash;

/** Test flashing */
return function () : Generator {
    /** We can flash and the message gets stored, but after toStringing it it is gone */
    yield function () {
        $msg = Flash::me('This is my awesome message!');
        assert($msg instanceof Flash);
        foreach (Flash::each() as $msg) {
            assert($msg instanceof Flash);
            assert("$msg" === 'This is my awesome message!');
        }
        $msgs = Flash::all();
        assert(count($msgs) === 0);
        Flash::me('test');
        Flash::flush();
        assert(count(Flash::all()) === 0);
    };
};

