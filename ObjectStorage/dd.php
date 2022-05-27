<?php
$str = '
{
    "mappings": {
        "properties": {
            "USER_ID": {
                "type": "keyword"
            },
            "ITEM_IDS": {
                "type": "keyword",
                "index": false
            },
            "date": {
                "type": "date",
                "format": "yyyy-MM-dd HH:mm:ss"
            }
        }
    }
}
';
$str = json_decode($str, true);
var_dump($str);

/*
array(1) {
    ["mappings"]=>
    array(1) {
      ["properties"]=>
      array(3) {
        ["USER_ID"]=>
        array(1) {
          ["type"]=>
          string(7) "keyword"
        }
        ["ITEM_IDS"]=>
        array(2) {
          ["type"]=>
          string(7) "keyword"
          ["index"]=>
          bool(false)
        }
        ["date"]=>
        array(2) {
          ["type"]=>
          string(4) "date"
          ["format"]=>
          string(19) "yyyy-MM-dd HH:mm:ss"
        }
      }
    }
  }
*/



// $edu = array(
//     'personalRecommend' => array(
//         'flag'     => true,
//         'ESindex'  => 'curation_personal',
//         'ESconfig' => 'USER_ID'
//     ),
//     'pop' => array(
//         'flag'     => true,
//         'ESindex'  => 'curation_pop',
//         'ESconfig' => 'pop'
//     ),
//     'relatedItem' => array(
//         'flag'     => true,
//         'ESindex'  => 'curation_related',
//         'ESconfig' => 'ITEM_ID'
//     )
// );

// var_dump($edu);
/*
array(3) {
    ["personalRecommend"]=>
    array(3) {
      ["flag"]=>
      bool(false)
      ["ESindex"]=>
      string(17) "curation_personal"
      ["ESconfig"]=>
      string(7) "USER_ID"
    }
    ["pop"]=>
    array(3) {
      ["flag"]=>
      bool(false)
      ["ESindex"]=>
      string(12) "curation_pop"
      ["ESconfig"]=>
      string(3) "pop"
    }
    ["relatedItem"]=>
    array(3) {
      ["flag"]=>
      bool(false)
      ["ESindex"]=>
      string(16) "curation_related"
      ["ESconfig"]=>
      string(7) "ITEM_ID"
    }
  }
*/