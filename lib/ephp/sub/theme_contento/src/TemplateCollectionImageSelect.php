<?php

namespace theme\contento;

class TemplateCollectionImageSelect extends TemplateCollectionImage {

function __construct() {
  parent::__construct();
  $this->closable = true;
  $this->table->select_event = 'IFRAME_MANAGER_CHILD.ret({ id : this.parentElement.parentElement.children[0].innerHTML})';
}

}
