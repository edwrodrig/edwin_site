<?php \ephp\web\Client::js_get_params() ?>

my.add_element = function(value, collection, config = {}) {
  var action = {
    action : 'contento_data_add',
    session : EPHP_USAC_CLIENT.get_session(),
    data: value,
    collection: collection
  };

  my.request(action, config);
};

my.add_image = function(form, config = {}) {
  form.append('session', EPHP_USAC_CLIENT.get_session());
  form.append('action', 'image_add');

  my.request(form, config);
}

my.edit_element = function(index, value, collection, config = {}) {
  var action = {
    action : 'contento_data_update',
    session : EPHP_USAC_CLIENT.get_session(),
    name: index,
    data: value,
    collection: collection
  };

  my.request(action, config);
};

my.edit_image_file = function(index, form, config = {}) {
  form.append('session', EPHP_USAC_CLIENT.get_session());
  form.append('action', 'image_update_file_by_id');
  form.append('id', index);
  
  my.request(form, config);
}

my.edit_image = function(index, value, config = {}) {
  var action = {
    action : 'image_update_by_id',
    session : EPHP_USAC_CLIENT.get_session(),
    id : index,
    description : value.description,
    sizes : value.sizes
  };

  my.request(action, config);
}


my.remove_element = function(index, collection, config = {}) {
  var action = {
    action : 'contento_data_delete',
    session: EPHP_USAC_CLIENT.get_session(),
    name: index,
    collection: collection
  };

  my.request(action, config);
};

my.get_element = function(index, collection, config = {}) {
  var action = {
    action : 'contento_data_by_name_collection',
    session: EPHP_USAC_CLIENT.get_session(),
    name: index,
    collection: collection
  };

  var success = config['success'];

  config['success']  = function(data) {
    success(data.data);
  };

  my.request(action, config);
};

my.get_elements = function(collection, config = {}) {
  var action =  {
    action : 'contento_data_by_collection',
    session: EPHP_USAC_CLIENT.get_session(),
    collection : collection
  };

  var success = config['success'];
  
  config['success'] = function(data) {
    var ret = [];
    for ( var i = 0 ; i < data.length ; i++ ) {
      ret.push(data[i].data);
    }
    success(ret);
  };

  my.request(action, config);
};

my.get_image = function(index, config = {}) {
  var action = {
    action : 'image_by_id',
    session: EPHP_USAC_CLIENT.get_session(),
    id : index
  };

  my.request(action, config);
}

my.get_images = function(config = {}) {
  var action = {
    action : 'image_by',
    session: EPHP_USAC_CLIENT.get_session()
  };

  my.request(action, config);
};

my.get_image_url = function(index) {
  return EPHP_USAC_CLIENT.url + '?action=image_file_by_id&session=' + EPHP_USAC_CLIENT.get_session() + '&id=' + index;
}

