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
        if(!$this->datas->require) {
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
        <div class="col-12">
            <h3>Dependencies <small>({$nb})</small></h3>
            <table class="table table-striped">
                <thead>
                    <tr style="text-align:left;">
                        <th>Package</th>
                        <th>Required version</th>
                        <th>Latest version</th>
                        <th>License</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
EOT;
        foreach($this->datas->require as $package) {
            $licenses = implode(',', $package->license);
            $html .= "<tr>
                <td><a href=\"{$package->homepage}\" target=\"_blank\">{$package->name}</a></td>
                <td>{$package->required}</td>"
                . ($package->latest ? "
                    <td>{$package->latest}</td>
                    <td>{$licenses}</td>
                    <td><small><a href=\"{$package->zip}\">download zip</a></small></td>" : "<td></td><td></td><td></td>")
                . "</tr>";
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