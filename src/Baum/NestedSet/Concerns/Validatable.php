<?php

namespace dvplex\Phantom\Baum\NestedSet\Concerns;

use dvplex\Phantom\Baum\NestedSet\Validator;

trait Validatable
{
    /**
     * Checks wether the underlying Nested Set structure is valid.
     *
     * @return boolean
     */
    public static function isValidNestedSet()
    {
        $validator = new Validator(new static);

        return $validator->passes();
    }
}
