<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 19-03-18
 * Time: 22:34
 */

namespace edwrodrig\site\theme;


class TemplatePost extends TemplatePage
{

    public function get_template_type() : string {
        return 'post';
    }

    public function get_url() : string {
        return '/posts/' . basename($this->filename, '.php');
    }

    public function get_title() {
        return $this->metadata->get_data()['title']['es'];
    }

    public function get_date() {
        return $this->metadata->get_data()['date'];
    }

    public function body() {?>
<div>
    <div class='section-container containter-padding'>
        <div class="bigger-font">
            <h1><?=$this->get_title()?></h1>
            <i class="fa fa-clock-o"></i><time><?=$this->get_date()?></time>
        </div>
        <hr/>
        <?php include $this->filename?>
    </div>
</div>
<?php
    }

}