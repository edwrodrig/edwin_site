<?php
namespace ephp\data;

function entity_iterator($array, $entity = '\ephp\data\Entity', $collection = null) {
  return new class($array, $entity) extends \ArrayIterator {
    public $entity;

    function __construct($array, $entity) {
      parent::__construct($array);
      $this->entity = $entity;
    }

    function current() {
      if ( is_callable($this->entity) ) {
        return ($this->entity)(parent::current());
      } else if ( is_string($this->entity) ) {
        return new $this->entity(parent::current());
      } else {
        return parent::current();
      }
    }

  };
}



