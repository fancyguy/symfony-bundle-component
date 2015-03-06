<?php
/**
 * This file is part of FancyGuy Bundle Component.
 *
 * Copyright (c) 2015 Steve Buzonas <steve@fancyguy.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FancyGuy\Component\Bundle;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Bundle\Bundle as BaseBundle;

abstract class Bundle extends BaseBundle
{

    /**
     * {@inheritDoc}
     */
    final public function getContainerExtension()
    {
        if (null === $this->extension) {
            $class = $this->getContainerExtensionClass();
            if (class_exists($class)) {
                $extension = new $class();

                $basename = preg_replace('/Bundle$/', '', $this->getName());
                $expectedAlias = Container::underscore(str_replace('FancyGuy', 'Fancyguy', $basename));
                if ($expectedAlias != $extension->getAlias()) {
                    throw new \LogicException(sprintf(
                        'The alias of the default extension should be the underscored version of the bundle name ("%s").',
                        $expectedAlias
                    ));
                }
            } else {
                $this->extension = false;
            }
        }

        if ($this->extension) {
            return $this->extension;
        }
    }
    
    /**
     * {@inheritDoc}
     */
    protected function getContainerExtensionClass()
    {
        return $this->getNamespace().'\\DependencyInjection\\BundleExtension';
    }
}
