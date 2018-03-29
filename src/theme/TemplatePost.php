<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 19-03-18
 * Time: 22:34
 */

namespace edwrodrig\site\theme;

use DateTime;
use edwrodrig\site\Site;

class TemplatePost extends TemplatePage
{

    public function get_template_type() : string {
        return 'post';
    }

    public function get_url() : string {
        return '/posts/' . $this->get_id();
    }

    public function get_date() : DateTime {
        return new DateTime($this->metadata->get_data()['date']);
    }

    static public function compare($a, $b) {
        return $a->get_date() <=> $b->get_date();
    }

    public function body() {?>
<div>
    <div class='section-container container-padding'>
        <header class="section-header post-box">
            <h1><?=Site::tr($this->get_title())?></h1>
            <i class="fa fa-clock-o"></i><time><?=Site::date_str($this->get_date())?></time>
        </header>
        <hr/>
        <?php
            /** @noinspection PhpIncludeInspection */
            include $this->filename;
        ?>
    </div>
</div>
<?php
    }


    public function html_link_box() {?>
    <a href="<?=$this->get_url()?>" class="clickable-box post-box">
        <h2><?=Site::tr($this->get_title())?></h2>
        <time><i class="fa fa-clock-o"></i><?=Site::date_str($this->get_date())?></time>
    </a>
<?php
    }
}