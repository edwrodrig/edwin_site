<?php
namespace edwrodrig\site\theme;

use edwrodrig\static_generator\Template;

class TemplatePage extends Template {

    public function body() {
        parent::print();
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
    </head>
    <body>
    <div>
        <div class="section-container" style="display:flex;justify-content:space-between">
            <a href="/">Edwin Rodríguez</a>
            <button type="button" class="nav-button">
                <i class="fa fa-bars"></i>
            </button>
        </div>
    </div>
    <?php $this->body()?>
    <div>
        <div class="section-container container-padding">
            <hr/>
            <div class="text-center">
                <?=date("Y")?> - Edwin Rodríguez León
            </div>
        </div>
    </div>
    <script>
        function toggle_nav() {
            var elem = document.getElementById('nav');
            if ( elem.hasAttribute('nav-show') )
                elem.removeAttribute('nav-show');
            else
                elem.setAttribute('nav-show', true);
        }
    </script>
    </body>
    </html>
    <?php
    }


    protected function social_buttons() {
        ?>

        $social_buttons = [
            ['http://www.github.com/edwrodrig', 'github'],
            ['http://www.linkedin.com/pub/edwin-iv%C3%A1n-rodr%C3%ADguez-le%C3%B3n/35/241/848', 'linkedin'],
            ['https://stackoverflow.com/users/2469099/edwin-rodr%c3%adguez?tab=profile', 'stack-overflow'],
            ['http://play.google.com/store/apps/developer?id=edwrodrig', 'android'],
            ['http://edwrodrig.deviantart.com/', 'deviantart'],
            ['https://twitter.com/edwrodrig', 'twitter'],
            ['http://www.pinterest.com/edwrodrig', 'pinterest'],
            ['http://www.codepen.io/edwrodrig', 'codepen'],
            ['https://www.youtube.com/user/edwrodrig1', 'youtube-play']
        ];
        ?>
        <div class="social-buttons-bars">

        </div>
        t__(['class' => [ 'layout-row', 'layout-center', 'grid-padding', 'layout-wrap', 'bigger-font']]);
        foreach ( $social_buttons as $button ) {
            t__('a', ['href' => $button[0]]);
            \ephp\web\Fa::icon($button[1]);
            __t();
        }
        __t();
<?php
    }


}

