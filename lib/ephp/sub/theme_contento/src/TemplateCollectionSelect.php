<?php

namespace theme\contento;

class TemplateCollectionSelect extends TemplateCollection {

function __construct($collection) {
  parent::__construct($collection);
  $this->closable = true;
  $this->table->select_event = 'IFRAME_MANAGER_CHILD.ret({ id : this.parentElement.parentElement.children[0].innerHTML})';
}

}
