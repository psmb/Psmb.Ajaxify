<?php
namespace Psmb\Ajaxify\Fusion;

use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Flow\Annotations as Flow;
use Neos\Neos\View\FusionView;
use Neos\Fusion\FusionObjects\AbstractFusionObject;

/**
 * Renders a Fusion view based on a path
 */
class RendererImplementation extends AbstractFusionObject {

	/**
	 * @Flow\Inject
	 * @var FusionView
	 */
	protected $view;

	/**
	 * @return mixed
	 * @throws \Exception
	 */
	public function evaluate() {
		$this->view->setControllerContext($this->runtime->getControllerContext());
		$node = $this->fusionValue('node');
		$renderPath = $this->fusionValue('renderPath');
		if (!$node instanceof NodeInterface) {
			throw new \Exception(sprintf('The node could not be resolved.'), 1677856609);
		}
		if (!$renderPath) {
			throw new \Exception(sprintf('The Fusion path could not be resolved.'), 1677857018);
		}
		$this->view->setFusionPath($renderPath);
		$this->view->assign('value', $node);
		return $this->view->render();
	}

}
