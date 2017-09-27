<?php
namespace ephp\mvc;

class ResponseHttp extends ResponseAssoc {

public $access_control_allow_origin = '*';

function __invoke($args = []) {
  if ( !empty($this->access_control_allow_origin) )
    header('Access-Control-Allow-Origin: ' . $this->access_control_allow_origin);

  $ret = parent::__invoke($args);
    
  if ( $data = self::validate_file_data($ret['data'] ?? []) ) {
    header("Cache-Control: public");
    header("Content-type: " . $data['type']);
    header("Content-Transfer-Encoding: Binary");
    header("Content-Length:". $data['length']);
    header("Content-Disposition: attachment; filename=" . $data['name']);
    if ( isset($data['filename']) )
      readfile($data['filename']);
    else
      echo $data['data'];
    return true;
  } else {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($ret);
    return true;
  }
}

private static function validate_file_data($data) {
  if ( ($data['__response_type'] ?? '') != 'file' ) return false;

  if ( file_exists($data['filename'] ?? '') ) {
    return [
      'name' => $data['name'] ?? pathinfo($data['filename'])['basename'],
      'type' => mime_content_type($data['filename']),
      'filename' => $data['filename'],
      'length' => filesize($data['filename'])
    ];
  }

  if ( isset($data['data']) ) {
    return [
      'name' => $data['name'] ?? 'data.txt',
      'length' => strlen($data['data']),
      'type' => $data['type'] ?? 'text/plain' ,
      'data' => $data['data']
    ];
  }

  return false;
}

}


