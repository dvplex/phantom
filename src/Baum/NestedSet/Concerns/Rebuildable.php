<?php

namespace dvplex\Phantom\Baum\NestedSet\Concerns;

use dvplex\Phantom\Baum\NestedSet\Builder;

trait Rebuildable
{
    /**
     * Rebuilds the structure of the current Nested Set.
     *
     * @param  bool $force
     * @return void
     */
    public static function rebuild($force = false)
    {
        $builder = new Builder(new static);

        $builder->rebuild($force);
    }
}
