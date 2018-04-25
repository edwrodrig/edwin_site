<?php
namespace edwrodrig\site\theme;

use edwrodrig\site\data\Image;
use edwrodrig\site\Site;
use edwrodrig\static_generator\Template;

class TemplatePage extends Template {

    public function body() {
        parent::print();
    }

    public function get_title() {
        return $this->metadata->get_data()['title'];
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
        <link rel="stylesheet" href="/style/style.css">

        <link rel="shortcut icon" sizes="16x16" href="<?=Image::contain('images/favicon.png', 16, 16)?>">
        <link rel="shortcut icon" sizes="24x24" href="<?=Image::contain('images/favicon.png', 24, 24)?>">
        <link rel="shortcut icon" sizes="32x32" href="<?=Image::contain('images/favicon.png', 32, 32)?>">
        <link rel="shortcut icon" sizes="48x48" href="<?=Image::contain('images/favicon.png', 48, 48)?>">
        <link rel="shortcut icon" sizes="64x64" href="<?=Image::contain('images/favicon.png', 64, 64)?>">


        <!-- Mobile (Android, iOS & others) -->
        <link rel="apple-touch-icon" sizes="57x57" href="<?=Image::contain('images/favicon.png', 57, 57)?>">
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?=Image::contain('images/favicon.png', 57, 57)?>">
        <link rel="apple-touch-icon" sizes="72x72" href="<?=Image::contain('images/favicon.png', 72, 72)?>">
        <link rel="apple-touch-icon" sizes="114x114" href="<?=Image::contain('images/favicon.png', 114, 114)?>">
        <link rel="apple-touch-icon" sizes="120x120" href="<?=Image::contain('images/favicon.png', 120, 120)?>">
        <link rel="apple-touch-icon" sizes="144x144" href="<?=Image::contain('images/favicon.png', 144, 144)?>">
        <link rel="apple-touch-icon" sizes="152x152" href="<?=Image::contain('images/favicon.png', 152, 152)?>">

        <!-- Windows 8 Tiles -->
        <meta name="application-name" content="<?=Site::tr(['es' => 'Página de Edwin Rodríguez', 'en' => 'Edwin Rodríguez\'s page'])?>">
        <meta name="msapplication-TileImage" content="<?=Image::contain('images/favicon.png', 144, 144)?>">
        <meta name="msapplication-TileColor" content="#2A2A2A">

        <!-- iOS Settings -->
        <meta content="yes" name="apple-mobile-web-app-capable">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <script src="/lib.js"></script>
        <title><?=Site::tr($this->get_title())?></title>
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
        <div class="container-padding" style="position:fixed;width:100%;display:flex;flex-direction:row-reverse;box-sizing:border-box">
            <button type="button" class="nav-button" onclick="ANIM.modal_in('nav-menu')">
                <i class="fa fa-bars"></i>
            </button>
        </div>
        <div class="container-padding header">
            <a class="header-name" href="/">Edwin Rodríguez</a>
        </div>
        <?php $this->nav_menu()?>
        <?php
    }

    public function nav_menu() {?>
        <div id="nav-menu" style="display:none">
            <div class="nav-menu-items">
                <h1>Edwin Rodríguez</h1>
                <a href="/"><?=Site::tr(['es' => 'Inicio', 'en' => 'Home'])?></a>
                <a href="/posts.html"><?=Site::tr(['es' => 'Artículos', 'en' => 'Article'])?></a>
                <a href="/projects.html"><?=Site::tr(['es' => 'Proyectos', 'en' => 'Projects'])?></a>
                <button type="button" class="nav-menu-close" onclick="ANIM.modal_out('nav-menu')"><i class="fa fa-times"></i></i></button>
            </div>
        </div>
        <?php
    }


    protected function body_footer() {
        ?>
        <div>
            <div class="section-container container-padding">
                <hr>
                <?php $this->social_buttons_bar() ?>
                <div class="footer-endline">
                    <?=date("Y")?> - Edwin Rodríguez León
                </div>
            </div>
        </div>
<?php
    }

    protected function social_buttons_bar() {
        ?>
        <div class="social-buttons-bar">
            <a href="http://www.github.com/edwrodrig" title="Github"><i class="fa fa-github"></i></a>
            <a href="http://www.linkedin.com/pub/edwin-iv%C3%A1n-rodr%C3%ADguez-le%C3%B3n/35/241/848" title="LinkedIn"><i class="fa fa-linkedin"></i></a>
            <a href="https://stackoverflow.com/users/2469099/edwin-rodr%c3%adguez?tab=profile" title="StackOverflow"><i class="fa fa-stack-overflow"></i></a>
            <a href="http://play.google.com/store/apps/developer?id=edwrodrig" title="Google Play"><i class="fa fa-android"></i></a>
            <a href="https://twitter.com/edwrodrig" title="Twitter"><i class="fa fa-twitter"></i></a>
            <a href="http://www.codepen.io/edwrodrig" title="Codepen"><i class="fa fa-codepen"></i></a>
            <a href="https://www.youtube.com/user/edwrodrig1" title="Youtube"><i class="fa fa-youtube-play"></i></a>
        </div>
        <?php
    }

}

