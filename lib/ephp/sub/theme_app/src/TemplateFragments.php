<?php

namespace theme\app;

trait TemplateFragments {

function fragment_button($content, ...$args) {
  return tag('button', ['class' => ['button'], 'type' => 'button'], ...$args)(\ephp\web\Util::ob_safe($content));
}

function fragment_form_basic($title, $input, $buttons = null, $links = null) {
  $form = t__('form', '#');
    t__('fieldset', ['class' => ['component']]);
      t__(['class' => ['grid-padding', 'layout-column']]);
        t__();
          tag(['class' => ['form-legend', 'text-center']])($title);
        __t();
        echo \ephp\web\Util::ob_safe($input);
        t__(['class' => ['form-padding']]);
          t__(['class' => ['layout-row', 'layout-wrap', 'layout-center', 'grid-padding']]);
            echo \ephp\web\Util::ob_safe($buttons);
          __t();
        __t();
        t__(['class' => ['text-center']]);
          echo \ephp\web\Util::ob_safe($links);
        __t();
      __t();
    __t();
  __t();

  return $form;

}

function fragment_button_close($args = []) {
  $this->fragment_button(tr(['es' => 'Cerrar', 'en' => 'Close']), ['onclick' => 'IFRAME_MANAGER_CHILD.close()'], $args);
}

function fragment_button_ok($args = []) {
  $this->fragment_button(tr(['es' => 'Entendido', 'en' => 'Ok']), ['onclick' => 'IFRAME_MANAGER_CHILD.close(true)'], $args);
}

function fragment_dialog_wait($message) {
  if ( empty($message) ) $message = tr(['es' => 'Cargando...', 'en' => 'Loading...']);
  $this->fragment_dialog('spinner', $message);
}

function fragment_dialog($icon = '', $title = '', $content = null) {
  t__(['class' => ['section-container-narrow', 'container-padding', ['width' => '100%', 'height' => '100%']]]);
  t__(['class' => ['layout-column', 'layout-center', ['width' => '100%', 'height' => '100%']]]);
  t__(['class' => ['layout-column', 'container-padding', 'text-center', ['background-color' => 'white', 'align-items' => 'center', 'border-radius' => '1em', 'overflow' => 'hidden']]]);
  if ( !empty($icon) ) {
    t__(['style' => ['font-size' => '3em']]);
      \ephp\web\Fa::icon($icon);
    __t();
  }
  tag('h2', ['style' => ['margin' => '0.5em 0']])($title);
  echo \ephp\web\Util::ob_safe($content);
  __t();
  __t();
  __t();
}

function fragment_page_wait($message) {
  if ( empty($message) ) $message = tr(['es' => 'Cargando...', 'en' => 'Loading...']);
  $this->fragment_page('spinner', $message);
}

function fragment_page($icon = '', $title = '', $content = null) {
  t__(['class' => ['section-container-narrow', 'container-padding', ['width' => '100%', 'height' => '100%']]]);
  t__(['class' => ['layout-column', 'layout-center', 'text-center', ['width' => '100%', 'height' => '100%', 'align-items' => 'center', 'overflow' => 'hidden']]]);
  if ( !empty($icon) ) {
    t__(['style' => ['font-size' => '3em']]);
      \ephp\web\Fa::icon($icon);
    __t();
  }
  tag('h2', ['style' => ['margin' => '0.5em 0']])($title);
  echo \ephp\web\Util::ob_safe($content);
  __t();
  __t();
}

}
