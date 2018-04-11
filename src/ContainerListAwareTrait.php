<?php

namespace Dhii\Data\Container;

use ArrayAccess;
use InvalidArgumentException;
use Psr\Container\ContainerInterface as BaseContainerInterface;
use stdClass;
use Traversable;

/**
 * Awareness of a list of containers.
 *
 * Validates the list, but not the items.
 *
 * @since [*next-version*]
 */
trait ContainerListAwareTrait
{
    /**
     * The list of containers.
     *
     * @since [*next-version*]
     *
     * @var BaseContainerInterface[]|array[]|stdClass[]|ArrayAccess[]|stdClass|Traversable
     */
    protected $containerList;

    /**
     * Assigns a list of containers to this instance.
     *
     * @since [*next-version*]
     *
     * @param BaseContainerInterface[]|array[]|stdClass[]|ArrayAccess[]|stdClass|Traversable $containers The containers to set.
     *
     * @throws InvalidArgumentException If not a valid list.
     */
    protected function _setContainerList($containers)
    {
        $containers = $this->_normalizeIterable($containers);

        $this->containerList = $containers;
    }

    /**
     * Retrieves the list of containers associated with this instance.
     *
     * @since [*next-version*]
     *
     * @return BaseContainerInterface[]|array[]|stdClass[]|ArrayAccess[]|stdClass|Traversable The list of containers.
     */
    protected function _getContainerList()
    {
        return is_null($this->containerList)
            ? [] // Default
            : $this->containerList;
    }

    /**
     * Normalizes an iterable.
     *
     * Makes sure that the return value can be iterated over.
     *
     * @since [*next-version*]
     *
     * @param mixed $iterable The iterable to normalize.
     *
     * @throws InvalidArgumentException If the iterable could not be normalized.
     *
     * @return array|Traversable|stdClass The normalized iterable.
     */
    abstract protected function _normalizeIterable($iterable);
}
