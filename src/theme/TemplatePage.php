<?php
namespace edwrodrig\site\theme;

use DateTime;
use edwrodrig\site\data\DataManager;
use edwrodrig\site\data\Image;
use edwrodrig\static_generator\cache\ImageItem;
use edwrodrig\static_generator\template\TemplateHtmlBasic;

class TemplatePage extends TemplateHtmlBasic {

    public function getTitle() {
        return $this->getData()['title'];
    }

    /**
     * @throws \edwrodrig\static_generator\exception\NoTranslationAvailableException
     */
    public function head() : void {?>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cutive+Mono|VT323">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/style/style.css">

        <link rel="shortcut icon" sizes="16x16" href="<?=$this->imageContain('favicon.png', 16, 16)?>">
        <link rel="shortcut icon" sizes="24x24" href="<?=$this->imageContain('favicon.png', 24, 24)?>">
        <link rel="shortcut icon" sizes="32x32" href="<?=$this->imageContain('favicon.png', 32, 32)?>">
        <link rel="shortcut icon" sizes="48x48" href="<?=$this->imageContain('favicon.png', 48, 48)?>">
        <link rel="shortcut icon" sizes="64x64" href="<?=$this->imageContain('favicon.png', 64, 64)?>">


        <!-- Mobile (Android, iOS & others) -->
        <link rel="apple-touch-icon" sizes="57x57" href="<?=$this->imageContain('favicon.png', 57, 57)?>">
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?=$this->imageContain('favicon.png', 57, 57)?>">
        <link rel="apple-touch-icon" sizes="72x72" href="<?=$this->imageContain('favicon.png', 72, 72)?>">
        <link rel="apple-touch-icon" sizes="114x114" href="<?=$this->imageContain('favicon.png', 114, 114)?>">
        <link rel="apple-touch-icon" sizes="120x120" href="<?=$this->imageContain('favicon.png', 120, 120)?>">
        <link rel="apple-touch-icon" sizes="144x144" href="<?=$this->imageContain('favicon.png', 144, 144)?>">
        <link rel="apple-touch-icon" sizes="152x152" href="<?=$this->imageContain('favicon.png', 152, 152)?>">

        <!-- Windows 8 Tiles -->
        <meta name="application-name" content="<?=$this->tr(['es' => 'Página de Edwin Rodríguez', 'en' => 'Edwin Rodríguez\'s page'])?>">
        <meta name="msapplication-TileImage" content="<?=$this->imageContain('favicon.png', 144, 144)?>">
        <meta name="msapplication-TileColor" content="#2A2A2A">

        <!-- iOS Settings -->
        <meta content="yes" name="apple-mobile-web-app-capable">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <script src="/lib.js"></script>
        <title><?=$this->tr($this->getTitle())?></title>
    <?php
    }

    /**
     * @throws \edwrodrig\static_generator\exception\NoTranslationAvailableException
     */
    public function body() : void {
        $this->bodyHeader();
        $this->bodyContent();
        $this->bodyFooter();
    }

    /**
     * @throws \edwrodrig\static_generator\exception\NoTranslationAvailableException
     */
    protected function bodyHeader() {
        ?>
        <div class="container-padding" style="position:fixed;width:100%;display:flex;flex-direction:row-reverse;box-sizing:border-box">
            <button type="button" class="nav-button" onclick="ANIM.modal_in('nav-menu')">
                <i class="fa fa-bars"></i>
            </button>
        </div>
        <div class="container-padding header">
            <a class="header-name" href="<?=$this->url('/')?>">Edwin Rodríguez</a>
        </div>
        <?php $this->navMenu();
    }

    /**
     * @throws \edwrodrig\static_generator\exception\NoTranslationAvailableException
     */
    public function navMenu() {?>
        <div id="nav-menu" style="display:none">
            <div class="nav-menu-items">
                <h1>Edwin Rodríguez</h1>
                <a href="<?=$this->url('/')?>"><?=$this->tr(['es' => 'Inicio', 'en' => 'Home'])?></a>
                <a href="<?=$this->url('/posts.html')?>"><?=$this->tr(['es' => 'Artículos', 'en' => 'Article'])?></a>
                <a href="<?=$this->url('/projects.html')?>"><?=$this->tr(['es' => 'Proyectos', 'en' => 'Projects'])?></a>
                <button type="button" class="nav-menu-close" onclick="ANIM.modal_out('nav-menu')"><i class="fa fa-times"></i></i></button>
            </div>
        </div>
        <?php
    }

    /**
     * The body content
     *
     * Echo the content between the {@see TemplatePage::bodyHeader() body header} and {@see TemplatePage::bodyFooter() body footer}.
     */
    protected function bodyContent() {
        /** @noinspection PhpIncludeInspection */
        include $this->page_info->getSourceAbsolutePath();
    }

    /**
     * The footer section.
     *
     * Contain just the {@see TemplatePage::socialButtonsBar() social buttons} and the current year with my name
     */
    protected function bodyFooter() {
        ?>
        <div>
            <div class="section-container container-padding">
                <hr>
                <?php $this->socialButtonsBar() ?>
                <div class="footer-endline">
                    <?=date("Y")?> - Edwin Rodríguez León
                </div>
            </div>
        </div>
<?php
    }

    /**
     * The social buttons section
     */
    protected function socialButtonsBar() {
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

    /**
     * Get the date in readable format.
     *
     * The date is already translated bt the {@see Template::getLang() current language}
     * @param DateTime $date
     * @return string
     */
    public function dateStr(DateTime $date) : string {
        $lang = $this->getLang();
        if ( $lang === 'es' ) {
            $date = ucwords(strftime('%A %e de %B de %G',  $date->getTimestamp()));
            return str_replace(' De ', ' de ', $date);
        } else if ( $lang === 'en' ) {
            return ucwords(strftime('%A, %B %e, %G', $date->getTimestamp()));
        } else {
            return strftime('%e/%m/%G', $date->getTimestamp());
        }
    }


    public function getRepos() : DataManager {
        return $this->page_info->getContext()->data;
    }

    /**
     * @param string $file
     * @param int $width
     * @param int $height
     * @return string
     * @throws \edwrodrig\static_generator\exception\CacheDoesNotExists
     */
    public function imageContain(string $file, int $width, int $height) {

        $image = new ImageItem(__DIR__ . '/../../data/images', $file, $width + $height);
        $image->resizeContain($width, $height);
        $image->setSalt();
        return strval($this->getCache('cache/images')->update($image));
    }



}

