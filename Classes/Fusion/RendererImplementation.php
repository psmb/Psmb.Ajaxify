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

	/**
	 * @Flow\Inject
	 * @var \Neos\Cache\Frontend\VariableFrontend
	 */
	protected $pathsCache;

	public function evaluate() {
		$this->view->setControllerContext($this->runtime->getControllerContext());
		$node = $this->fusionValue('node');
		$pathKey = $this->fusionValue('pathKey');
		$renderPath = $this->pathsCache->get($pathKey);
		if (!$renderPath) {
			throw new \Exception(sprintf('Render path not found for key %s', $pathKey));
		}
		$this->view->setFusionPath($renderPath);
		$this->view->assign('value', $node);
		return $this->view->render();
	}

}
