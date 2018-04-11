<?php

namespace Dhii\Di;

use ArrayAccess;
use Dhii\Data\Container\ContainerGetCapableTrait;
use Dhii\Data\Container\ContainerHasCapableTrait;
use Dhii\Data\Container\ContainerInterface;
use Dhii\Data\Container\ContainerListGetCapableTrait;
use Dhii\Data\Container\ContainerListHasCapableTrait;
use Dhii\Data\Container\CreateContainerExceptionCapableTrait;
use Dhii\Data\Container\CreateNotFoundExceptionCapableTrait;
use Dhii\Data\Container\NormalizeKeyCapableTrait;
use Dhii\Exception\CreateInvalidArgumentExceptionCapableTrait;
use Dhii\Exception\CreateOutOfRangeExceptionCapableTrait;
use Dhii\I18n\StringTranslatingTrait;
use Dhii\Util\Normalization\NormalizeIterableCapableTrait;
use Dhii\Util\Normalization\NormalizeStringCapableTrait;
use Psr\Container\ContainerInterface as BaseContainerInterface;
use stdClass;
use Traversable;

/**
 * A container that contains other containers.
 *
 * It uses a list of child containers. Every time `has()` or `get()` is invoked, it iterates through the list,
 * and gives the first matching result. This means that results of containers that come before will override results
 * from containers that come after. The results are not cached, meaning that if the list of containers changes
 * (such as if a traversable object), then the result of `has()` or `get()` may also change.
 *
 * @since [*next-version*]
 */
class CompositeContainer implements ContainerInterface
{
    /* Awareness of a list of containers.
     *
     * @since [*next-version*]
     */
    use ContainerListAwareTrait;

    /* Ability to retrieve a service from a list of containers.
     *
     * @since [*next-version*]
     */
    use ContainerListGetCapableTrait;

    /* Ability to check a list of containers for a key.
     *
     * @since [*next-version*]
     */
    use ContainerListHasCapableTrait;

    /* Ability to retrieve a value from a container.
     *
     * @since [*next-version*]
     */
    use ContainerGetCapableTrait;

    /* Ability to check for a value in a container.
     *
     * @since [*next-version*]
     */
    use ContainerHasCapableTrait;

    /* Basic i18n capability.
     *
     * @since [*next-version*]
     */
    use StringTranslatingTrait;

    /* Ability to normalize values to string.
     *
     * @since [*next-version*]
     */
    use NormalizeStringCapableTrait;

    /* Ability to normalize values to iterable.
     *
     * @since [*next-version*]
     */
    use NormalizeIterableCapableTrait;

    /* Ability to normalize container keys.
     *
     * @since [*next-version*]
     */
    use NormalizeKeyCapableTrait;

    /* Factory of Invalid Argument exception.
     *
     * @since [*next-version*]
     */
    use CreateInvalidArgumentExceptionCapableTrait;

    /* Factory of Container exception.
     *
     * @since [*next-version*]
     */
    use CreateContainerExceptionCapableTrait;

    /* Factory of Not Found exception.
     *
     * @since [*next-version*]
     */
    use CreateNotFoundExceptionCapableTrait;

    /* Factory of Out of Range exception.
     *
     * @since [*next-version*]
     */
    use CreateOutOfRangeExceptionCapableTrait;

    /**
     * @since [*next-version*]
     *
     * @param BaseContainerInterface[]|array[]|stdClass[]|ArrayAccess[]|stdClass|Traversable $containers A list of containers.
     */
    public function __construct($containers)
    {
        $this->_setContainerList($containers);
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function get($key)
    {
        return $this->_containerListGet($key, $this->_getContainerList());
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function has($key)
    {
        return $this->_containerListHas($key, $this->_getContainerList());
    }
}
