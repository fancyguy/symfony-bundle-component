<?php
/**
 * This file is part of FancyGuy Bundle Component.
 *
 * Copyright (c) 2015 Steve Buzonas <steve@fancyguy.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FancyGuy\Component\Bundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Extension as BaseExtension;
use Symfony\Component\DependencyInjection\Exception\BadMethodCallException;

abstract class Extension extends BaseExtension
{

    /**
     * {@inheritDoc}
     */
    public function getNamespace()
    {
        return 'http://fancyguy.com/schema/dic/'.$this->getAlias();
    }

    /**
     * {@inheritDoc}
     */
    public function getAlias()
    {
        try {
            return parent::getAlias();
        } catch (BadMethodCallException $e) {
            $className = get_class($this);
            if (substr($className, -16) != '\\BundleExtension') {
                throw $e;
            }
            $aliasBaseName = str_replace(array('FancyGuy', '\\Bundle\\', '\\BundleExtension'), array('Fancyguy', '', ''), $className);
            return Container::underscore($aliasBaseName);
        }
    }
}
