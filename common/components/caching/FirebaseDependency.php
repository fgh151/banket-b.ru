<?php


namespace app\common\components\caching;


use yii\caching\CacheInterface;
use yii\caching\Dependency;

class FirebaseDependency extends Dependency
{

    /**
     * Generates the data needed to determine if dependency is changed.
     * Derived classes should override this method to generate the actual dependency data.
     * @param CacheInterface $cache the cache component that is currently evaluating this dependency
     * @return mixed the data needed to determine if dependency has been changed.
     */
    protected function generateDependencyData($cache)
    {
        // TODO: Implement generateDependencyData() method.
    }
}