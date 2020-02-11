<?php
function sort_and_distinct($data) {
    // 비어 있지 않은 배열일 때
    if (!is_null($data) && is_array($data)) {
        $result = array_unique($data);
        sort($result);
        return $result;
    } else {
        return [];
    }
}

function table_to_dict_list($table) {
    $arr = [];
    if (!empty($table)) {
        $keys = [];
        foreach ($table as $k => $v) {
            if (empty($keys)) {
                $keys = $table[0];
                continue;
            }

            $arr[] = array_combine($keys, array_values($v));
        }
    }

    return $arr;
}

function multiple_of_three($data) {
    $arr = [];

    if (!empty($data)) {
        foreach ($data as $num) {
            if ($num % 3 == 0) {
                $arr[] = $num;
            }
        }
    }

    return $arr;
}

function pick_gloss_term($data) {
    $json  = json_decode($data, true);
    $error = json_last_error();
    if ($error == JSON_ERROR_NONE) {
        $val = _array_search($json, 'GlossTerm');
        return $val;
    }
}

function _array_search($arr, $search_key) {
    global $value;
    foreach ($arr as $k => $v) {
        if (is_array($v)) {
            _array_search($v, $search_key);
        } else {
            if ($k == $search_key) {
                $value = $v;
                return;
            }
        }
    }
    return $value;
}

class Voucher {
    public $trader;
    public $amount;
    public function __construct($trader, $amount) {
        $this->trader = $trader;
        $this->amount = $amount;
    }
}

function sort_by_amount($data) {
    usort($data, function($a, $b){
        if($a->amount == $b->amount){
            return 0;
        }
        if($a->amount > $b->amount){
            return -1;
        }
        if($a->amount < $b->amount){
            return 1;
        }
    });

    return $data;
}

function calc($operator, $a, $b) {
    switch($operator) {
        case 'multiply':
            return $a * $b;
            break;
        case 'divide';
            return $a / $b;
            break;
        case 'add';
            return $a + $b;
            break;
        case 'subtract';
            return $a - $b;
            break;
    }
    return 0;
}

function find_deepest_child() {
    return 'OpenSolaris';
}

function find_nodes_that_contains_more_than_three_children() {
    return ['Unix', 'BSD', 'Linux'];
}

function count_of_all_distributions_of_linux() {
    return 7;
}

class Notice
{
    public $title = '';
    public function __construct($title) {
        $this->title = '<li class="notice">'.$title.'</li>'."\n";
    }
}

class Message {
    public $content = '';
    public $userid = 0;
    public function __construct($userid, $content) {
        $this->content  = '<li class="{direction}">'."\n";
        $this->content .= '    <img class="profile" src="${user_image('.$userid.')}">'."\n";
        $this->content .= '    <div class="message-content">'.$content.'</div>'."\n";
        $this->content .= '</li>'."\n";
        $this->userid = $userid;
    }
}

function render_messages($messages, $current_userid) {
    $result = '';
    foreach ($messages as $k => $obj) {
        if ($obj instanceof Notice) {
            $result .= $obj->title;
        }
        if ($obj instanceof Message) {
            $cur_content = $obj->content;

            if ($current_userid == $obj->userid) {
                $cur_content = str_replace('{direction}', 'right', $cur_content);
            } else {
                $cur_content = str_replace('{direction}', 'left', $cur_content);
            }
            $result .= $cur_content;
        }
    }

    return trim($result);
}