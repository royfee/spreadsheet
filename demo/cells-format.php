<?php

require __DIR__ . '/_config.php';

\royfee\spreadsheet\Helper::newSpreadsheet()
    ->addData(
	[
		['field'=>'index','value'=>'No.', 'width'=>10],
		['field'=>'name','value'=>'Name', 'width'=>20],
		['field'=>'sex','value'=>'Sex', 'width'=>20]
	],
	[
		[
			'name'=>'ZhangSan','sex'=>'M'
		],
		[
			'name'=>'Panxiaoting','sex'=>'F'
		]
	])
	/*
    ->addRows([
        ['Basic Plan', "*Interface\n*Search Tool"],
        ['Advanced Plan', "*Interface\n*Search Tool\n*Statistics"],
    ])
    ->setWrapText()
    // ->setWrapText('B2')
    ->setAutoSize()
    // ->setAutoSize('B')
    ->setStyle([
        'borders' => [
            'inside' => ['borderStyle' => 'hair'],
            'outline' => ['borderStyle' => 'thin'],
        ],
        'fill' => [
            'fillType' => 'solid',
            'startColor' => ['argb' => 'FFCCCCCC'],
        ],
    ])
	*/
    ->output('Formatted Excel');  