<?php
namespace Psmb\Ajaxify\Fusion;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Log\SystemLoggerInterface;
use Neos\Neos\View\FusionView;
use Neos\Fusion\FusionObjects\AbstractFusionObject;
use Neos\Neos\Exception as NeosException;

/**
 * Renders a Fusion view based on a path
 */
class RendererImplementation extends AbstractFusionObject {

	/**
	 * @Flow\Inject
	 * @var FusionView
	 */
	protected $view;

	public function evaluate() {
		$this->view->setControllerContext($this->runtime->getControllerContext());
		$node = $this->fusionValue('node');
		$renderPath = $this->fusionValue('renderPath');
		$this->view->assign('value', $node);
		$this->view->setFusionPath($renderPath);
		return $this->view->render();
	}

}
