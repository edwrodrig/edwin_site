my.get_session = function() {
  return window.localStorage.getItem('ephp_usac_client_session');
};

my.is_user_logged = function() {
  return my.get_username() != undefined && my.get_session() !=  undefined;
}

my.set_session = function(session) {
  window.localStorage.setItem('ephp_usac_client_session', session);
};

my.unset_session = function() {
  window.localStorage.removeItem('ephp_usac_client_session');
};  

my.get_username = function() {
  return window.localStorage.getItem('ephp_usac_client_username');
};

my.set_username = function(username) {
  window.localStorage.setItem('ephp_usac_client_username', username);
};

my.unset_username = function() {
  window.localStorage.removeItem('ephp_usac_client_username');
};  

my.user_login = function(action, config = {}) {
  action['action'] = 'user_login';

  var success = config['success'];  

  config['success'] = function(data) {
    my.set_username(data.username);
    my.set_session(data.session);
    success(data);
  };

  my.request(action, config);
};

my.user_login_guest = function(config = {}) {
  var action = {
    action : 'user_login_guest'
  };

  var success = config['success'];

  config['success'] = function(data) {
    my.set_username(data.username);
    my.set_session(data.session);
    success(data);
  };

  my.request(action, config);
};

my.session_check = function(config = {}) {
  var action = {
    action : 'session_username',
    session: my.get_session()
  };

  var success = config['success'];

  config['success'] = function(username) {
    my.set_username(username);
    success(username);
  }

  var error = config['error'];

  config['error'] = function(data) {
    my.unset_username();
    my.unset_session();
    error(data);
  }

  my.request(action, config);
};

my.session_logout = function(config = {}) {
  var action = {
    action : 'session_logout',
    session: my.get_session()
  };

  var success = config['success'];
  
  config['success'] = function(data) {
    my.unset_session();
    my.unset_username();
    success(data);
  };

  var error = config['error'];

  config['error'] = function(data) {
    my.unset_session();
    my.unset_username();
    error(data);
  };

  my.request(action, config);
};

my.user_signin = function(action, config = {}) {
  EPHP_TOKAC_CLIENT.entry_execute(action, config);
};

my.user_change_password = function(action, config = {}) {
  EPHP_TOKAC_CLIENT.entry_execute(action, config);
};

my.user_request_signin = function(action, config = {}) {
  action['action'] = 'user_request_signin';
  action['lang'] = my.current_lang;
  my.request(action, config);
};

my.user_change_mail = function(config = {}) {
  EPHP_TOKAC_CLIENT.entry_execute({}, config);
};

my.user_request_change_password = function(action, config = {}) {
  action['action'] = 'user_request_change_password';
  action['lang'] = my.current_lang;
  my.request(action, config);
};

my.session_request_change_mail = function(action, config = {}) {
  action['action'] = 'session_request_change_mail';
  action['session'] = my.get_session();
  action['lang'] = my.current_lang;
  my.request(action, config);
};


