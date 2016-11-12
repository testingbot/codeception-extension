<?php
namespace Codeception\Extension;

require_once 'vendor/autoload.php';

use TestingBot\TestingBotAPI;


/**
 * Class TestingBotExtension
 *
 * @author TestingBot <info@testingbot.com>
 * @license MIT
 */
class TestingBotExtension extends \Codeception\Platform\Extension {
	static $events = array(
		'test.fail' => 'testFailed',
		'test.error' => 'testFailed',
		'test.success' => 'testSuccess',
	);

	public function testFailed(\Codeception\Event\FailEvent $e) {
		$key = (getenv('TB_KEY') ? getenv('TB_KEY') : $this->config['key']);
		$secret = (getenv('TB_KEY') ? getenv('TB_SECRET') : $this->config['secret']);

		$api = new TestingBotAPI($key, $secret);

		$current = $e->getTest()->getMetadata()->getCurrent();

		if (!array_key_exists("\TestingBotWebDriver", $current["modules"])) {
			return;
		}

		$sessionID = $current["modules"]["\TestingBotWebDriver"]->webDriver->getSessionID();

		$api->updateJob($sessionID, array('success' => false, 'status_message' => $e->getFail()->getMessage(), 'name' => $e->getTest()->toString()));
	}

	public function testSuccess(\Codeception\Event\TestEvent $e) {
		$key = (getenv('TB_KEY') ? getenv('TB_KEY') : $this->config['key']);
		$secret = (getenv('TB_KEY') ? getenv('TB_SECRET') : $this->config['secret']);

		$api = new TestingBotAPI($key, $secret);

		$current = $e->getTest()->getMetadata()->getCurrent();
		
		if (!array_key_exists("\TestingBotWebDriver", $current["modules"])) {
			return;
		}

		$sessionID = $current["modules"]["\TestingBotWebDriver"]->webDriver->getSessionID();

		$api->updateJob($sessionID, array('success' => true, 'name' => $e->getTest()->toString()));
	}
}