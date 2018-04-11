# Dhii - Composite Container

[![Build Status](https://travis-ci.org/Dhii/composite-container.svg?branch=develop)](https://travis-ci.org/Dhii/composite-container)
[![Code Climate](https://codeclimate.com/github/Dhii/composite-container/badges/gpa.svg)](https://codeclimate.com/github/Dhii/composite-container)
[![Test Coverage](https://codeclimate.com/github/Dhii/composite-container/badges/coverage.svg)](https://codeclimate.com/github/Dhii/composite-container/coverage)
[![Latest Stable Version](https://poser.pugx.org/dhii/composite-container/version)](https://packagist.org/packages/dhii/composite-container)
[![Latest Unstable Version](https://poser.pugx.org/dhii/composite-container/v/unstable)](https://packagist.org/packages/dhii/composite-container)
[![This package complies with Dhii standards](https://img.shields.io/badge/Dhii-Compliant-green.svg?style=flat-square)][Dhii]

## Details
An composite implementation of the [PSR-11][] standard. This container allows sequentially querying a list of child
containers for a key. Every child container can be anything that passes normalization with
[`NormalizeContainerCapableTrait#_normalizeContainer()`][NormalizeContainerCapableTrait#_normalizeContainer()].


### Classes
- [`CompositeContainer`][CompositeContainer] - The composite container implementation. Does not cache results.
- [`ContainerListAwareTrait`][ContainerListAwareTrait] - Awareness of a list of containers.

[Dhii]:                                                 https://github.com/Dhii/dhii
[PSR-11]:                                               https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-11-container.md

[CompositeContainer]:                                   src/CompositeContainer.php
[ContainerListAwareTrait]:                              src/ContainerListAwareTrait.php

[NormalizeContainerCapableTrait#_normalizeContainer()]: https://github.com/Dhii/container-helper-base/blob/develop/src/NormalizeContainerCapableTrait.php#L32
