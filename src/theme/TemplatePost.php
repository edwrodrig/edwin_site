<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 19-03-18
 * Time: 22:34
 */

namespace edwrodrig\site\theme;

use function edwrodrig\static_generator\tr;

class TemplatePost extends TemplatePage
{

    public function get_template_type() : string {
        return 'post';
    }

    public function get_url() : string {
        return '/posts/' . $this->get_id();
    }

    public function get_title() {
        return tr($this->metadata->get_data()['title']);
    }

    public function get_date() {
        return $this->metadata->get_data()['date'];
    }

    static public function compare($a, $b) {
        return $a->get_date() <=> $b->get_date();
    }

    public function body() {?>
<div>
    <div class='section-container containter-padding'>
        <div class="bigger-font">
            <h1><?=$this->get_title()?></h1>
            <i class="fa fa-clock-o"></i><time><?=$this->get_date()?></time>
        </div>
        <hr/>
        <?php
            /** @noinspection PhpIncludeInspection */
            include $this->filename;
        ?>
    </div>
</div>
<?php
    }

}