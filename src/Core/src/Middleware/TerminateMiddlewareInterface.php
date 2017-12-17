<?php
/**
 * Created by PhpStorm.
 * User: deller
 * Date: 16.12.17
 * Time: 21:45
 */
namespace Core\Middleware;

/**
 * Interface TerminateMiddlewareInterface
 * @package Core\Middleware
 */
interface TerminateMiddlewareInterface
{
    /**
     * @return bool
     */
    public function isTerminate():bool;
}
