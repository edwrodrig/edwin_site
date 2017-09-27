<?php

namespace theme\app;

trait TemplateCommon {

use TemplateFragments;

static public $style = [
  'font_normal' => "'Helvetica Neue', Helvetica, Arial, sans-serif",
  'font_color' => '#555',
  'font_emph_color' => '#317eac',
  'background_color' => 'white',
  'nav_background_color' => '#2fa4e7'
];


function styles() {
  \ephp\web\Fa::html_include();
?>
<style>
body {
  color: <?=self::$style['font_color']?>;
  font-family: <?=self::$style['font_normal']?>;
}

h1, h2, h3, h4, h5, h6 {
  font-weight: 500;
  line-height: 1.2;
  color: <?=self::$style['font_emph_color']?>;
}

a {
  color: #2fa4e7;
  text-decoration: none;
}

a:hover, a:focus {
  color: #157ab5;
  text-decoration: underline;
}

p {
  margin: 0 0 1em;
}

fieldset {
  padding: 0;
  margin: 0;
  border: 0;
  min-width: 0;
}
<?php
  \ephp\web\TemplatePage::style_layout();

  style('.section-container-narrow', [
    'box-sizing' => 'border-box',
    '@media ( min-width : 500px )' => [
      'width' => '500px',
      'max-width' => '500px',
      'margin' => '0 auto',
      'overflow-x' => 'hidden'
    ]
  ]);

  style('.grid-padding', [
    'margin-top' => '-0.5em',
    'margin-left' => '-0.5em',
    '> *' => [
      'box-sizing' => 'border-box', 
      'margin' => '0.5em'
    ]
  ]);

  style('.container-padding', [
    'padding' => '1em'
  ]);

  style('.component', [
    'box-sizing' => 'border-box',
    'position' => 'relative',
    'padding' => '1.5em',
    'background-color' => '#f5f5f5',
    'border' => '1px solid #e3e3e3',
    'border-radius' => '0.5em',
    'box-shadow' => 'inset 0 1px 1px rgba(0, 0, 0, 0.05)',
    'overflow-x' => 'hidden'
  ]);

  style('.form-padding', [
    'padding-top' => '1em'
  ]);

  style('.form-legend' , [
    'width' => '100%',
    'padding' => '0',
    'font-size' => '1.2em',
    'color' => '#555',
    'border' => '0',
    'border-bottom' => '1px solid #e5e5e5',
    'margin-bottom' => '0.5em',
    'padding-bottom' => '0.5em',
    'box-sizing' => 'border-box'
  ]);

  style('.form-label' , [
    'text-align' => 'right',
    'margin-bottom' => '0.35em',
    'display' => 'inline-block',
    'max-width' => '100%',
    'font-weight' => 'bold'
  ]);

  style('.form-control', [
    'box-sizing' => 'border-box',
    'display' => 'block',
    'width' => '100%',
    'height' => '2.7em',
    'padding' => '0.6em 0.85em',
    'line-height' => '1.42857143',
    'color' => '#555',
    'background-color' => '#fff',
    'border' => '1px solid #ccc',
    'border-radius' => '4px',
    'box-shadow' => 'inset 0 1px 1px rgba(0, 0, 0, 0.075)',
    'trans' => [
      'border-color' => 'ease-in-out .15s',
      'box-shadow' => 'ease-in-out .15s'
    ],
    ':focus' => [
      'border-color' => '#66afe9',
      'outline' => 0,
      'box-shadow' => 'inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, 0.6)'
    ]
  ]);

  style('.form-help', [
    'display' => 'block',
    'margin-top' => '0.2em',
    'color' => '#959595'
  ]);


  style('.button', [
    'display' => 'inline-block',
    'font-weight' => 'normal',
    'text-align' => 'center',
    'vertical-align' => 'middle',
    'touch-action' => 'manipulation',
    'cursor' => 'pointer',
    'border' => '1px solid transparent',
    'white-space' => 'nowrap',
    'padding' => '0.6em 0.85em',
    'line-height' => '1.42857143',
    'border-radius' => '4px',
    'color' => '#555',
    'background-color' => '#fff',
    'border-color' => 'rgba(0, 0, 0, 0.1)',
    'text-shadow' => '0 1px 0 rgba(0, 0, 0, 0.1)',
    ':focus' => [
      'color' => '#555555',
      'background-color' => '#e6e6e6',
      'border-color' => 'rgba(0, 0, 0, 0.1)'
    ],
    ':hover' => [
      'color' => '#555555',
      'background-color' => '#e6e6e6',
      'border-color' => 'rgba(0, 0, 0, 0.1)'
    ]
  ]);

  style('.title-block', [
    'background-color' => self::$style['nav_background_color'],
    'color' => '#fff'
  ]);

  style('.button-primary', [
    'background-color' => '#2fa4e7',
    'color' => '#fff',
    'border-color' => '#178acc',
    ':focus' => [
      'color' => '#fff',
      'background-color' => '#178acc',
      'border-color' => '#105b87'
    ],
    ':hover' => [
      'color' => '#fff',
      'background-color' => '#178acc',
      'border-color' => '#105b87'
    ]
  ]);

  echo "</style>";
}

}
