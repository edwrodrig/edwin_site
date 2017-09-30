<?php

namespace ephp\web;

class Iframe {

static function open($content) {
  BuilderState::push();
  $code = 'IFRAME_MANAGER_PARENT.open_content('. json_encode(Util::ob_safe($content)). ')';
  BuilderState::pop();

  return $code;
}

static function js_functions_common() {
if ( dg() ) :
?>
<script>
function slot_set_placeholder(id, innerHTML) {
  document.getElementById(id).innerHTML = innerHTML;
}

window.addEventListener('message', function(event) {
  if ( event.data.action == 'slot' ) {
    if (typeof window[event.data.data.slot] === 'function')
      window[event.data.data.slot].apply(null, event.data.data.args);
  }
    
});
</script>
<?php
endif;
}

static function js_functions_child() {
if ( dg() ) :
?>
<script>
var IFRAME_MANAGER_CHILD = {
  close : function (chain) {
    chain =  typeof chain !== 'undefined' ? chain : false;
    this.signal('slot_close_child', chain);
  },
  signal : function(action) {
    var args = [];
    for ( var i = 1 ; i < arguments.length ; i++ )
      args.push(arguments[i]);
    parent.postMessage({ action : 'slot', data : { slot: action, args : args  } }, '*');
  },
  ret: function() {
    this.callback.apply(this, arguments);
    this.close();
  },
  callback : function() {
    var args = Array.prototype.slice.call(arguments);
    args.unshift("slot_callback");
    this.signal.apply(this, args);
  }
};
</script>
<?php

self::js_functions_common();
endif;
}

static function js_functions_parent() {
if ( dg() ) :
?>
<script>
var IFRAME_MANAGER_PARENT = {
  iframe : null,
  get_iframe : function() {
    return this.iframe.contentWindow || this.iframe.contentDocument.document || this.iframe.contentDocument;
  },
  create : function() {
    if ( this.iframe != null ) this.close();
    this.iframe = document.createElement('iframe');
    this.iframe.style = "top:0;left:0;position:fixed;width:100%;height:100%;border:0;opacity:0;transition:opacity 0.5s";
    document.body.style.overflow = 'hidden';
    this.iframe.onload = function() { IFRAME_MANAGER_PARENT.iframe.style.opacity = 1; };
  },
  open_content : function(content) {
    this.create();
    document.body.appendChild(this.iframe);
    ifrm = this.get_iframe();
    ifrm.document.open();
    ifrm.document.write(content);
    ifrm.document.close();
  },
  open_url : function(url) {
    this.create();
    this.iframe.src = url;
    document.body.appendChild(this.iframe);
  },
  close : function() {
    if ( this.iframe == null ) return;
    this.iframe.style.opacity = 0;
    setTimeout(function() {
      document.body.removeChild(IFRAME_MANAGER_PARENT.iframe);
      IFRAME_MANAGER_PARENT.iframe = null;
      document.body.style.overflow = null;
    }, 500);
  },
  signal : function(action) {
    var args = [];
    for ( var i = 1 ; i < arguments.length ; i++ )
      args.push(arguments[i]);

    var inter = setInterval(function() {
      if ( IFRAME_MANAGER_PARENT.iframe == null ) { 
        clearInterval(inter);
        return;
      }
      if ( IFRAME_MANAGER_PARENT.iframe.contentWindow.document.readyState === "complete") {
        IFRAME_MANAGER_PARENT.iframe.contentWindow.postMessage({ action : 'slot', data : { slot: action, args : args  }}, '*');
        clearInterval(inter);
      }
    }, 100);
  }
};

function slot_callback() {
  if ( typeof IFRAME_MANAGER_PARENT.callback === 'function' ) {
    IFRAME_MANAGER_PARENT.callback.apply(IFRAME_MANAGER_PARENT, arguments);
  }
}

function slot_close_child(chain) {
  if ( chain && typeof IFRAME_MANAGER_CHILD !== 'undefined' ) {
    IFRAME_MANAGER_CHILD.close();
  } else {
    IFRAME_MANAGER_PARENT.close();
  }
}

function slot_go_to(url) {
  window.location.href = url;
}

function slot_back() {
  window.history.back();
}
</script>
<?php

self::js_functions_common();
endif;

}

}
