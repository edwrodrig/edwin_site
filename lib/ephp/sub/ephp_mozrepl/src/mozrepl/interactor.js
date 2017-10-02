

function c(repl) {
  return repl._workContext;
};

function log(repl, content) {
  return c(repl).content.console.log(content);
}

function url(repl, arg) {
  repl._workContext.content.location.href = arg;
}

function current_url(repl) {
  var href = c(repl).content.location.href;
  log(repl, href);
  repl.print(href);
}

function is_ready(repl) {
  if ( c(repl).content.document.readyState == 'complete' ) repl.print('true');
  else repl.print('false');
}

function get_element(repl, type, name) {
  var doc = c(repl).content.document;
  if ( type == 'id' ) {
    var s = doc.getElementById(name);
    log(repl, s);
    if ( s === undefined ) return null;
    else return s;
  } else if ( type == 'name' ) {
    var s = doc.getElementsByName(name);
    if ( s === undefined ) return null;
    if ( s.length < 1 ) return null;
    if ( s[0].type == 'radio' ) return s;
    else return s[0];
  }  else {
    var query = '[' + type + '="' + name + '"]';
    var s = doc.querySelector(query);
    if (s === undefined) return null;
    else return s;
  }
}

function set_value(repl, type, name, value) {
  value = value.split('+1*2#3-4_5').join(' ');
  var target = get_element(repl, type, name);
  if ( target === null ) return;
  if ( c(repl).content.NodeList.prototype.isPrototypeOf(target) ) {
    for ( var i = 0 ; i < target.length ; i++ ) {
      if ( target[i].value == value ) {
        target[i].checked = true;
        return;
      }
    }
  } else target.value = value;
}

function get_value(repl, type, name) {
  var elem = get_element(repl, type, name);
  if ( elem === null ) return null;
  var result = (function(target) {
    if ( c(repl).content.NodeList.prototype.isPrototypeOf(target) ) {
      log(repl, target);
      for ( var i = 0 ; i < target.length ; i++ ) {
        if ( target[i].checked )
          return target[i].value;
      }
    } else if ( target.type == 'select-one' ) {
      return target.options[target.selectedIndex].text;
    } else return target.value;
  })(elem);
  log(repl, 'element value');
  log(repl, result);
  repl.print(result);
}

function click(repl, type, name) {
  var target = get_element(repl, type, name);
  var result = true;
  if ( target === null ) result = false;
  else if ( target.click !== undefined ) target.click();
  else {
    var evObj = c(repl).content.document.createEvent('Events');
    evObj.initEvent('click', true, false);
    target.dispatchEvent(evObj);
  }
  repl.print(result);
}

function click_pos(repl, x, y) {
  var doc = c(repl).content.document;
  doc.elementFromPoint(x, y).click();
}

function change(repl, type, name) {
  var target = get_element(repl, type, name);
  var result = true;
  if ( target === null ) result = false;
  //else if ( target.onchange !== undefined ) target.onchange();
  else {
    var evObj = c(repl).content.document.createEvent('Events');
    evObj.initEvent('change', true, false);
    target.dispatchEvent(evObj);
  }
  repl.print(result);
}

function get_table(repl, type, name) {
  var table = get_element(repl, type, name);
  if ( table === null ) return null;
  if ( table.tagName !== 'TABLE' ) return null;
  var out = [];
  for (var i = 0, row; row = table.rows[i]; i++) {
    var current_row = [];
    for (var j = 0, col; col = row.cells[j]; j++) {
      current_row.push(col.innerHTML);
    }
    out.push(current_row);
  }
  return repl.print(JSON.stringify(out));
}

repl.defineInteractor('ephp', {
        onStart: function(repl) {
        },
    
        getPrompt: function(repl) {
            return 'ephp> ';
        },
    
        handleInput: function(repl, input) {
            var args = input.replace(/^\s+|\s+$/g, '').split(/\s+/);
            log(repl, "command");
            log(repl, args); 
            var command = args[0];
    
            switch(command) {
            case 'is_ready':
                is_ready(repl);
                break; 
            case 'q':
                repl.popInteractor(); // returns to previous interactor
                break;
            case 'table' :
                get_table(repl, args[1], args[2]);
                break;
            case 'get':
                get_value(repl, args[1], args[2]);
                break;
            case 'click':
                click(repl, args[1], args[2]);
                break;
            case 'click_pos':
                click_pos(repl, args[1], args[2]);
                break;
            case 'change':
                change(repl, args[1], args[2]);
                break;
            case 'set':
                set_value(repl, args[1], args[2], args[3]);
                break; 
            case 'url':
                url(repl, args[1]);
                break;
            case 'location':
                current_url(repl); 
                break;
            default:
                break;
            }
            repl._prompt();
        }
});

