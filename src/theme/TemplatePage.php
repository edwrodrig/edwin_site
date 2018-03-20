<?php
namespace edwrodrig\site\theme;

use edwrodrig\static_generator\Template;

class TemplatePage extends Template {

    public function body() {
        parent::print();
    }

    public function get_title() {
        return $this->metadata->get_data()['title']['es'];
    }

    /**
     * @throws \Exception
     */
    public function print() {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cutive+Mono|VT323">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/style.css">
        <script src="/lib.js"></script>
        <title><?=$this->get_title()?></title>
    </head>
    <body>
    <?php $this->body_header()?>
    <?php $this->body()?>
    <?php $this->body_footer()?>
    </body>
    </html>
    <?php
    }

    protected function body_header() {
        ?>
        <div>
            <div class="section-container" style="display:flex;justify-content:space-between">
                <a href="/">Edwin Rodríguez</a>
                <button type="button" class="nav-button" onclick="ANIM.modal_in('nav-menu')">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
        </div>
        <div id="nav-menu" style="display:none">
            <a href="/">Home</a>
            <a href="/posts.html">Artículos</a>
            <a href="/projects.html">Proyectos</a>
            <button type="button" onclick="ANIM.modal_out('nav-menu')">Close</button>
        </div>
        <?php
    }


    protected function body_footer() {
        ?>
        <div>
            <div class="section-container container-padding">
                <div class="social-buttons-bar">
                    <a href="http://www.github.com/edwrodrig"><i class="fa fa-github"></i></a>
                    <a href="http://www.linkedin.com/pub/edwin-iv%C3%A1n-rodr%C3%ADguez-le%C3%B3n/35/241/848"><i class="fa fa-linkedin"></i></a>
                    <a href="https://stackoverflow.com/users/2469099/edwin-rodr%c3%adguez?tab=profile"><i class="fa fa-stack-verflow"></i></a>
                    <a href="http://play.google.com/store/apps/developer?id=edwrodrig"><i class="fa fa-android"></i></a>
                    <a href="http://edwrodrig.deviantart.com/"><i class="fa fa-deviantart"></i></a>
                    <a href="https://twitter.com/edwrodrig"><i class="fa fa-twitter"></i></a>
                    <a href="http://www.pinterest.com/edwrodrig"><i class="fa fa-pinterest"></i></a>
                    <a href="http://www.codepen.io/edwrodrig"><i class="fa fa-codepen"></i></a>
                    <a href="https://www.youtube.com/user/edwrodrig1"><i class="fa fa-youtube-play"></i></a>
                </div>
                <div class="text-center">
                    <?=date("Y")?> - Edwin Rodríguez León
                </div>
            </div>
        </div>
<?php
    }

}

