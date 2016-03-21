<?php
namespace ComposerExtension;

use Hal\Application\Extension\Reporter\ReporterHtmlSummary;

class HtmlRenderer implements ReporterHtmlSummary {

    /**
     * @var \StdClass;
     */
    private $datas;

    /**
     * HtmlRenderer constructor.
     * @param \StdClass $datas
     */
    public function __construct(\StdClass $datas)
    {
        $this->datas = $datas;
    }

    /**
     * @inheritdoc
     */
    public function getMenus()
    {
        // you can add one or more items to the menu
        return [
            'composer' => 'Composer'
        ];
    }

    /**
     * @inheritdoc
     */
    public function renderJs()
    {
        // add your Js code here
        return "document.getElementById('link-composer').onclick = function() { displayTab(this, 'composer')};";
    }

    /**
     * @inheritdoc
     */
    public function renderHtml()
    {
        if(!$this->datas->name) {
            return <<<EOT
<div class="tab" id="composer">
    <div class="row">
        <h3>No result</h3>
        <p>
            No composer.json file found
        </p>
    </div>
EOT;
        }

        $this->datas->require = (array) $this->datas->require;
        $this->datas->authors= (array) $this->datas->authors;
        $nb = sizeof($this->datas->require);

        $html = <<<EOT
<div class="tab" id="composer">
    <div class="row">
        <div class="col-6">
            <h3>Dependencies <small>({$nb})</small></h3>
            <table class="table table-striped">
                <tbody>
EOT;
        foreach($this->datas->require as $name => $version) {
            $html .= "<tr><td>{$name}</td><td>{$version}</td></tr>";
        }
        $html .= <<<EOT
                </tbody>
            </table>
        </div>

        <div class="col-3">
            <h3>Authors</h3>
            <table class="table table-striped">
                <tbody>
EOT;
        foreach($this->datas->authors as $author) {
            $html .= "<tr><td></td><td href=\"{$author->email}\">{$author->name}</td><td>{$author->role}</td></tr>";
        }
        $html .= <<<EOT
            </tbody>
            </table>
        </div>
    </div>
</div>
EOT;

        return $html;
    }

}