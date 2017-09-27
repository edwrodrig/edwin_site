<?php

namespace ephp\web;

abstract class Client {

public $name;
public $server;
public $class_path;


static function js_form_to_json() {
?>
my.form_to_json = function(form_id) {
  var action = {};
  var form = document.getElementById(form_id);
  var elements = form.elements;
  for ( var i = 0 ; i < elements.length ; i++ ) {
    if ( elements[i].tagName == "INPUT" )
      action[elements[i].name] = elements[i].value;
  }
  return action;
}
<?php
}

static function js_get_params() {
?>
my.get_token = function() {
  var params = location.href.split('?');
  if ( params[1] === undefined ) return [];
  params = params[1].split('&');
  if ( params[0] === undefined ) return '';
  return params[0];
};
<?php
}

function js_script() {
?>
<script>
var <?=$this->name?> = (function() {
  var my = {};

  my.url = "<?=$this->server?>";

  my.current_lang = "<?=\ephp\Format::$current_lang?>";

  my.request = function(action, config = {}) {
    var url = this.url;
    var success = function(data) { alert(JSON.stringify(data)); }
    var error = function(data) { alert(JSON.stringify(data)); }

    if ( config.hasOwnProperty('url') ) {
      url = config.url;
    }

    if ( config.hasOwnProperty('success') ) {
      success = config.success;
    }

    if ( config.hasOwnProperty('error') ) {
      error = config.error;
    }

    var xhr = new XMLHttpRequest;
    xhr.open("POST", url, true);
    xhr.onload = function(e) {
      try {
        if ( xhr.status != 200 ) throw { code: xhr.status, message : xhr.statusText };
        var r = JSON.parse(xhr.response);
        if ( r ) {
         if ( r.status >= 0 ) success(r.data);
         else {
           console.log(r);
           error(r);
         }
        } else {
          console.log(e.target.status);
          error({ status: -1, code: -1, message: e.target.status});
        }
      } catch ( e ) {
        console.log(xhr.response);
        console.log(e);
        error({ status: -1,  code: -2, message: e.message, excep: e });
      }
    };

    xhr.onerror = function(e) {
      console.log(xhr.status);
      console.log(xhr.response);
      error({ status: -1,  code: -2, message: e.target.status });
    };

    if ( action instanceof FormData )
      xhr.send(action);
    else
      xhr.send(JSON.stringify(action));
  };

  my.form_to_json = function(form_id) {
    var action = {};
    var form = document.getElementById(form_id);
    var elements = form.elements;
    for ( var i = 0 ; i < elements.length ; i++ ) {
      if ( elements[i].tagName == "INPUT" )
        action[elements[i].name] = elements[i].value;
    }
    return action;
  };

<?php
if ( file_exists($this->class_path . '/client.js') )
  include($this->class_path . '/client.js');

if ( file_exists($this->class_path . '/method') ) {
  foreach (new \DirectoryIterator($this->class_path . '/method') as $file) {
    if ( $file->getExtension() !== 'js' ) continue;
    printf( 'my.%s = ',  $file->getBasename('.js'));
    include($file->getPathname());
  }
}
?>

  return my;
})();
</script>
<?php
}

}
