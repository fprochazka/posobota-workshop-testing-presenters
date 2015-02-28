<?php

namespace Test;

use App\Presenters\HomepagePresenter;
use Nette,
	Tester,
	Tester\Assert;

require __DIR__ . '/bootstrap.php';


class HomepageTest extends TestCase
{

	/**
	 * @var HomepagePresenter
	 */
	private $presenter;



	public function setUp()
	{
		$sl = $this->getContainer();
		$sl->removeService('http.request');
		$sl->addService('http.request', new Nette\Http\Request(new Nette\Http\UrlScript('http://www.kdyby.org')));

		$services = $sl->findByType(HomepagePresenter::class);
		$this->presenter = $sl->getService($services[0]);
		$this->presenter->autoCanonicalize = FALSE;
	}



	public function testSomething()
	{
		$sl = $this->getContainer();

		$response = $this->presenter->run(new Nette\Application\Request('Homepage', 'GET', ['action' => 'default']));

		ob_start();
		$response->send($sl->getByType(Nette\Http\Request::class), $sl->getByType(Nette\Http\Response::class));
		$content = ob_get_clean();

		$dom = Tester\DomQuery::fromHtml($content);

		$results = $dom->find('.article h2');

		Assert::same('kdyby doctrine', (string) $results[0]);

	}

}


$test = new HomepageTest();
$test->run();
