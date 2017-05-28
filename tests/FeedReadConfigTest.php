<?php

namespace Feedr\Test;

use Feedr\Core\Config\FeedReadConfig;
use Feedr\Specs\Atom;
use Feedr\Specs\RSS;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

/**
 * Class FeedReadConfigTest
 * @package Feedr\Test
 */
class FeedReadConfigTest extends TestCase
{
    /** @var FeedReadConfig */
    protected $feedReadConfig;

    protected function setUp()
    {
        $this->feedReadConfig = new FeedReadConfig(new RSS());
    }

    public function testSpec()
    {
        $this->assertInstanceOf(RSS::class, $this->feedReadConfig->getSpec());

        $this->feedReadConfig->setSpec(new Atom());
        $this->assertInstanceOf(Atom::class, $this->feedReadConfig->getSpec());
    }

    public function testTempPath()
    {
        $this->assertEquals('', $this->feedReadConfig->getTempPath());

        $this->feedReadConfig->setTempPath('temp');
        $this->assertEquals('temp', $this->feedReadConfig->getTempPath());
    }

    public function testLogger()
    {
        $this->assertInstanceOf(NullLogger::class, $this->feedReadConfig->getLogger());
    }
}
