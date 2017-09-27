<?php
(new TemplatePage(<<<EOF
{
  "name": "object",
  "type": "object",
  "fields": [
    {"field": "line", "type": "string", "required" : true, "desc" : { "es" : "alguna descripcion", "en" : "some description" }},
    {"field": "area", "type": "string", "style" : "area", "tr" : true},
    {"field": "rich", "type": "string", "style" : "rich", "tr" : true },
    {"field": "nested" , "type" : "object", "fields" : [
      {"field": "line", "type": "string", "tr" : true},
      {"field": "area", "type": "string", "style" : "area", "tr" : true},
      {"field": "rich", "type": "string", "style" : "rich", "tr" : true }
    ]}
  ]
}
EOF
))();
