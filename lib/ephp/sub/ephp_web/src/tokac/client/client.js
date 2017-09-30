<?php \ephp\web\Client::js_get_params() ?>

my.entry_check = function(config = {}) {
  var action = {
    action : 'tokac_entry_check',
    token : my.get_token()
  };
  my.request(action, config);
};

my.entry_execute = function(user_data, config = {}) {
  var action = {
    action: 'tokac_entry_execute',
    token : my.get_token(),
    user_data : user_data
  };

  my.request(action, config);
};
