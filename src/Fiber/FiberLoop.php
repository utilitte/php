<?php declare(strict_types = 1);

namespace Utilitte\Php\Fiber;

use Fiber;

final class FiberLoop
{

	/**
	 * @param Fiber[] $fibers
	 */
	public function __construct(
		private array $fibers = [],
	)
	{
	}

	public function addCallable(callable $callback): void
	{
		$this->addFiber(new Fiber($callback));
	}

	public function addFiber(Fiber $fiber): void
	{
		$this->fibers[] = $fiber;
	}

	public function loop(): void
	{
		foreach ($this->fibers as $fiber) {
			if (!$fiber->isStarted()) {
				$fiber->start();
			}
		}

		while (true) {
			foreach ($this->fibers as $key => $fiber) {
				if ($fiber->isTerminated()) {
					unset($this->fibers[$key]);
				} else if ($fiber->isSuspended()) {
					$fiber->resume();
				}
			}

			if (!$this->fibers) {
				break;
			}
		}
	}

}
