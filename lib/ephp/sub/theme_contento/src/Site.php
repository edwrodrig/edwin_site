<?php

namespace theme\contento;

class Site {

public $collections;

public function generate() {

foreach ( $this->collections as $collection) {
  $collection = $collection['data'];

  \ephp\web\Context::file_process(
    '/collection/' . $collection['name'] . '/element.html',
    function() use($collection) {
      TemplateElement::create($collection)->print();
    }
  );


  \ephp\web\Context::file_process(
    '/collection/' . $collection['name'] . '/list.html',
    function() use($collection) {
      TemplateCollection::create($collection)->print();
    }
  );


  \ephp\web\Context::file_process(
    '/collection/' . $collection['name'] . '/select.html',
    function() use($collection) {
      TemplateCollectionSelect::create($collection)->print();
    }
  );
}

\ephp\web\Context::file_process(
  '/collection/image/element.html',
  function() {
    TemplateImage::create()->print();
  }
);


\ephp\web\Context::file_process(
  '/collection/image/list.html',
  function() {
    TemplateCollectionImage::create()->print();
  }
);


\ephp\web\Context::file_process(
  '/collection/image/select.html',
  function() {
    TemplateCollectionImageSelect::create()->print();
  }
);


\ephp\web\Context::file_process(
  '/main.html',
  function() {
    TemplateMain::create($this->collections)->print();
  }
);



}

}
