<?php
use PHPUnit\Framework\TestCase;
include(dirname(__FILE__)."/impl.php");
class QuizTest extends TestCase
{
    public function testTableToDictList() {
        $table = [
            ['월', '일', '품명', '수량', '단가', '공급가액', '부가세', '코드', '거래처명'],
            ['01', '01', '어헤드', '', '', '10,364', '1,036', '00140', '흑자스토어'],
            ['01', '01', '어헤드', '', '', '10,999', '1,101', '00406', '서울스토어'],
            ['01', '01', '어헤드', '', '', '1,818', '182', '00237', '핏펫스토어'],
        ];

        $dict_list = table_to_dict_list($table);
        $this->assertEquals('10,364', $dict_list[0]['공급가액']);
        $this->assertEquals('서울스토어', $dict_list[1]['거래처명']);
    }

    public function testFilterList() {
        $data = range(0, 100);

        $filtered = multiple_of_three($data);

        foreach ($filtered as $num) {
            $this->assertEquals($num % 3, 0);
        }

    }

    public function testJson() {
        $data = '{
    "glossary": {
        "title": "example glossary",
		"GlossDiv": {
            "title": "S",
			"GlossList": {
                "GlossEntry": {
                    "ID": "SGML",
					"SortAs": "SGML",
					"GlossTerm": "Standard Generalized Markup Language",
					"Acronym": "SGML",
					"Abbrev": "ISO 8879:1986",
					"GlossDef": {
                        "para": "A meta-markup language, used to create markup languages such as DocBook.",
						"GlossSeeAlso": ["GML", "XML"]
                    },
					"GlossSee": "markup"
                }
            }
        }
    }
}';

        $this->assertEquals('Standard Generalized Markup Language', pick_gloss_term($data));
    }

    public function testSortedDistinctList() {
        $arr = [1, 5, 8, 10, 4, 9, 11, 10, 8, 14, 3, 4];
        $sorted_arr = sort_and_distinct($arr);

        $this->assertEquals([1, 3, 4, 5, 8, 9, 10, 11, 14], $sorted_arr);
    }

    public function testCustomSort() {
        $data = [
            new Voucher('잇쮸', 125000),
            new Voucher('어헤드', 8500),
            new Voucher('플라고', 288000),
            new Voucher('잇츄', 80000),
        ];

        $vouchers = sort_by_amount($data);

        $this->assertEquals('플라고', $vouchers[0]->trader);
        $this->assertEquals('어헤드', $vouchers[3]->trader);
    }

    public function testDispatchByString() {
        $this->assertEquals(18, calc('multiply', 6, 3));
        $this->assertEquals(2,  calc('divide', 6, 3));
        $this->assertEquals(9,  calc('add', 6, 3));
        $this->assertEquals(3,  calc('subtract', 6, 3));
    }

    public function testTraverse() {
        $unix_tree = [
            'Unix' => [
                'PWB/Unix' => [
                    'System III' => [
                        'HP-UX' => null,
                    ],
                    'System V' => [
                        'UnixWare' => null,
                        'Solaris' => [
                            'OpenSolaris' => null,
                        ]
                    ]
                ],
                'BSD' => [
                    'Unix 9'  => null,
                    'FreeBSD' => null,
                    'NetBSD'  => null,
                    'MacOS'   => null,
                ],
                'Xenix' => [
                    'Sco Unix' => [
                        'OpenServer' => null,
                    ],
                    'AIX' => null,
                ],
            ],
            'Linux' => [
                'Debian' => [
                    'Ubuntu'     => null,
                    'Linux Mint' => null,
                ],
                'Redhat' => [
                    'CentOS' => null,
                    'Fedora' => null,
                ],
                'Gentoo' => null,
            ],
        ];

        $this->assertEquals('OpenSolaris', find_deepest_child($unix_tree));
        $this->assertEquals(['Unix', 'BSD', 'Linux'], find_nodes_that_contains_more_than_three_children($unix_tree));
        $this->assertEquals(7, count_of_all_distributions_of_linux($unix_tree));
    }

    public function testPolymorphism() {
        $messages = [
            new Notice('Welcome to chat'),
            new Message($userid = 1, $content = 'Hello World'),
            new Message($userid = 2, $content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'),
            new Message($userid = 3, $content = '안녕하세요.'),
            new Message($userid = 2, $content = 'ありがとうございます。'),
        ];

        $this->assertEquals('<li class="notice">Welcome to chat</li>
<li class="left">
    <img class="profile" src="${user_image(1)}">
    <div class="message-content">Hello World</div>
</li>
<li class="right">
    <img class="profile" src="${user_image(2)}">
    <div class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
</li>
<li class="left">
    <img class="profile" src="${user_image(3)}">
    <div class="message-content">안녕하세요.</div>
</li>
<li class="right">
    <img class="profile" src="${user_image(2)}">
    <div class="message-content">ありがとうございます。</div>
</li>', render_messages($messages, 2));

    }
}
