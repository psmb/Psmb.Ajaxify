<?php
namespace Psmb\Ajaxify\Fusion;

use Exception;
use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Flow\Annotations as Flow;
use Neos\Neos\View\FusionView;
use Neos\Fusion\FusionObjects\AbstractFusionObject;

/**
 * Renders a partial based on a content node and a Fusion path.
 */
class RendererImplementation extends AbstractFusionObject {

	/**
	 * @Flow\Inject
	 * @var FusionView
	 */
	protected $view;

	/**
	 * @return mixed
	 * @throws Exception
	 */
	public function evaluate() {
		$node = $this->fusionValue('node');
		$fusionPath = $this->fusionValue('fusionPath');

		if (!$node instanceof NodeInterface) {
			throw new Exception(sprintf('The node could not be resolved.'), 1677856609);
		}
		if (!$fusionPath) {
			throw new Exception(sprintf('The Fusion path could not be resolved.'), 1677857018);
		}

		$this->view->setControllerContext($this->runtime->getControllerContext());
		$this->view->setFusionPath($fusionPath);
		$this->view->assign('value', $node);
		return $this->view->render();
	}

}
