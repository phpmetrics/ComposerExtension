<?php
namespace ComposerExtension;

use Hal\Application\Config\Configuration;
use Hal\Application\Extension\Extension;
use Hal\Application\Extension\Reporter;
use Hal\Application\Extension\ReporterHtmlSummary;
use Hal\Component\Bounds\Bounds;
use Hal\Component\File\Finder;
use Hal\Component\Result\ResultCollection;

require_once __DIR__.'/HtmlRenderer.php';

class ComposerExtension implements Extension {

    /**
     * @var \StdClass
     */
    private $datas;

    /**
     * @inheritdoc
     */
    public function receive(Configuration $configuration, ResultCollection $collection, ResultCollection $aggregatedResults, Bounds $bounds)
    {
        $this->datas = new \StdClass;

        // search compose.json files
        $finder = new Finder('json', $configuration->getPath()->getExcludedDirs());
        $files = $finder->find($configuration->getPath()->getBasePath());
        var_dump($files);
        foreach($files as $filename) {
            if(!preg_match('/composer\.json|composer-dist\.json/', $filename)) {
                continue;
            }
            $this->datas = (object) json_decode(file_get_contents($filename));
            break;
        }
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'composer';
    }

    /**
     * @inheritdoc
     */
    public function getReporterHtmlSummary()
    {
        return new HtmlRenderer($this->datas);
    }

    /**
     * @inheritdoc
     */
    public function getReporterCliSummary()
    {
        return null;
    }
}
return new ComposerExtension();