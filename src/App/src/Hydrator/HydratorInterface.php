<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 17.12.17
 * Time: 16:20
 */

namespace App\Hydrator;

/**
 * Interface HydratorInterface
 * @package App\Hydrator
 */
interface HydratorInterface
{
    /**
     * @param array $data
     * @param object $object
     * @return object
     */
    public function hydrate(array $data, $object);
}
