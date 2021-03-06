<?php

declare(strict_types=1);

namespace Akeneo\Platform;

/**
 * Class VersionProvider
 *
 * @author    Nicolas Dupont <nicolas@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class VersionProvider implements VersionProviderInterface
{
    /** @var string */
    private $edition;

    /** @var string */
    private $version;

    /** @var string */
    private $codeName;

    /**
     * @param string $versionClass
     */
    public function __construct(string $versionClass)
    {
        $versionClass = new \ReflectionClass($versionClass);
        $this->version = $versionClass->getConstant('VERSION');
        $this->edition = $versionClass->getConstant('EDITION');
        $this->codeName = $versionClass->getConstant('VERSION_CODENAME');
    }

    /**
     * {@inheritdoc}
     */
    public function getEdition(): string
    {
        return $this->edition;
    }

    /**
     * {@inheritdoc}
     */
    public function getMajor(): string
    {
        $matches = [];
        preg_match('/^(?P<major>\d+)/', $this->version, $matches);

        return $matches['major'];
    }

    /**
     * {@inheritdoc}
     */
    public function getMinor(): string
    {
        $matches = [];
        preg_match('/^(?P<minor>\d+.\d+)/', $this->version, $matches);

        return $matches['minor'];
    }

    /**
     * {@inheritdoc}
     */
    public function getPatch(): string
    {
        $matches = [];
        preg_match('/^(?P<patch>\d+.\d+.\d+)/', $this->version, $matches);

        return $matches['patch'];
    }

    /**
     * {@inheritdoc}
     */
    public function getStability(): string
    {
        $matches = [];
        preg_match('/-(?P<stability>\w+)\d+$/', $this->version, $matches);

        return (isset($matches['stability'])) ? $matches['stability'] : 'stable';
    }

    /**
     * {@inheritdoc}
     */
    public function getFullVersion(): string
    {
        return $this->version . ' ' . $this->codeName;
    }
}
