<?php

namespace Dhii\Data\Container\FuncTest;

use Dhii\Data\Container\CompositeContainer as TestSubject;
use Psr\Container\ContainerInterface as BaseContainerInterface;
use Xpmock\TestCase;
use Exception as RootException;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_MockObject_MockBuilder as MockBuilder;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class CompositeContainerTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\Data\Container\CompositeContainer';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @param array|null $methods         The methods to mock.
     * @param array      $constructorArgs The arguments to pass to the SUT constructor.
     *
     * @return MockObject|TestSubject The new instance.
     */
    public function createInstance($methods = [], $constructorArgs = [])
    {
        is_array($methods) && $methods = $this->mergeValues($methods, [
            '__',
        ]);

        $mock = $this->getMockBuilder(static::TEST_SUBJECT_CLASSNAME)
            ->setMethods($methods)
            ->setConstructorArgs($constructorArgs)
            ->getMock();

        return $mock;
    }

    /**
     * Merges the values of two arrays.
     *
     * The resulting product will be a numeric array where the values of both inputs are present, without duplicates.
     *
     * @since [*next-version*]
     *
     * @param array $destination The base array.
     * @param array $source      The array with more keys.
     *
     * @return array The array which contains unique values
     */
    public function mergeValues($destination, $source)
    {
        return array_keys(array_merge(array_flip($destination), array_flip($source)));
    }

    /**
     * Creates a mock that both extends a class and implements interfaces.
     *
     * This is particularly useful for cases where the mock is based on an
     * internal class, such as in the case with exceptions. Helps to avoid
     * writing hard-coded stubs.
     *
     * @since [*next-version*]
     *
     * @param string   $className      Name of the class for the mock to extend.
     * @param string[] $interfaceNames Names of the interfaces for the mock to implement.
     *
     * @return MockBuilder The builder for a mock of an object that extends and implements
     *                     the specified class and interfaces.
     */
    public function mockClassAndInterfaces($className, $interfaceNames = [])
    {
        $paddingClassName = uniqid($className);
        $definition = vsprintf('abstract class %1$s extends %2$s implements %3$s {}', [
            $paddingClassName,
            $className,
            implode(', ', $interfaceNames),
        ]);
        eval($definition);

        return $this->getMockBuilder($paddingClassName);
    }

    /**
     * Creates a mock that uses traits.
     *
     * This is particularly useful for testing integration between multiple traits.
     *
     * @since [*next-version*]
     *
     * @param string[] $traitNames Names of the traits for the mock to use.
     *
     * @return MockBuilder The builder for a mock of an object that uses the traits.
     */
    public function mockTraits($traitNames = [])
    {
        $paddingClassName = uniqid('Traits');
        $definition = vsprintf('abstract class %1$s {%2$s}', [
            $paddingClassName,
            implode(
                ' ',
                array_map(
                    function ($v) {
                        return vsprintf('use %1$s;', [$v]);
                    },
                    $traitNames)),
        ]);
        var_dump($definition);
        eval($definition);

        return $this->getMockBuilder($paddingClassName);
    }

    /**
     * Creates a new exception.
     *
     * @since [*next-version*]
     *
     * @param string $message The exception message.
     *
     * @return RootException|MockObject The new exception.
     */
    public function createException($message = '')
    {
        $mock = $this->getMockBuilder('Exception')
            ->setConstructorArgs([$message])
            ->getMock();

        return $mock;
    }

    /**
     * Creates a new invocable object.
     *
     * @since [*next-version*]
     *
     * @return MockObject An object that has an `__invoke()` method.
     */
    public function createCallable()
    {
        $mock = $this->getMockBuilder('MyCallable')
            ->setMethods(['__invoke'])
            ->getMock();

        return $mock;
    }

    /**
     * Creates a new container.
     *
     * @since [*next-version*]
     *
     * @param array|null $methods The methods to mock.
     *
     * @return MockObject|BaseContainerInterface The new container.
     */
    public function createContainer($methods = [])
    {
        is_array($methods) && $methods = $this->mergeValues($methods, [
            '__',
        ]);

        $mock = $this->getMockBuilder('Psr\Container\ContainerInterface')
            ->getMock();

        return $mock;
    }

    /**
     * Tests whether a valid instance of the test subject can be created.
     *
     * @since [*next-version*]
     */
    public function testCanBeCreated()
    {
        $subject = $this->createInstance(null, [[]]);

        $this->assertInstanceOf(
            static::TEST_SUBJECT_CLASSNAME,
            $subject,
            'A valid instance of the test subject could not be created.'
        );
    }

    /**
     * Tests whether `has()` and `get()` works as expected.
     *
     * @since [*next-version*]
     */
    public function testHasGet()
    {
        $key1 = uniqid('key');
        $val1 = uniqid('val');
        $key2 = uniqid('key');
        $val2 = uniqid('val');
        $key3 = uniqid('key');
        $val3 = uniqid('val');
        $keyOther = uniqid('non-existing-key');
        $container1 = $this->createContainer(['has', 'get']);
        $container2 = $this->createContainer(['has', 'get']);
        $container3 = $this->createContainer(['has', 'get']);
        $containerList = [$container1, $container2, $container3];
        $subject = $this->createInstance(null, [$containerList]);
        $_subject = $this->reflect($subject);

        $container1->expects($this->any())
            ->method('has')
            ->will($this->returnValueMap([
                [$key1, true],
                [$key2, false],
                [$key3, false],
                [$keyOther, false],
            ]));
        $container1->expects($this->any())
            ->method('get')
            ->will($this->returnValueMap([
                [$key1, $val1],
                [$key2, null],
                [$key3, null],
            ]));

        $container2->expects($this->any())
            ->method('has')
            ->will($this->returnValueMap([
                [$key1, false],
                [$key2, true],
                [$key3, false],
                [$keyOther, false],
            ]));
        $container2->expects($this->any())
            ->method('get')
            ->will($this->returnValueMap([
                [$key1, null],
                [$key2, $val2],
                [$key3, null],
            ]));

        $container3->expects($this->any())
            ->method('has')
            ->will($this->returnValueMap([
                [$key1, false],
                [$key2, false],
                [$key3, true],
                [$keyOther, false],
            ]));
        $container3->expects($this->any())
            ->method('get')
            ->will($this->returnValueMap([
                [$key1, null],
                [$key2, null],
                [$key3, $val3],
            ]));

        $this->assertTrue($subject->has($key1));
        $this->assertEquals($val1, $subject->get($key1));

        $this->assertTrue($subject->has($key2));
        $this->assertEquals($val2, $subject->get($key2));

        $this->assertTrue($subject->has($key3));
        $this->assertEquals($val3, $subject->get($key3));

        $this->assertFalse($subject->has($keyOther));
        $this->setExpectedException('Psr\Container\ContainerExceptionInterface');
        $subject->get($keyOther);
    }
}
