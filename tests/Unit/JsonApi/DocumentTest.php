<?php

use App\JsonApi\Document;

it('can create json api document', function () {

    $category = Mockery::mock('App\Models\Category', function ($mock){
        $mock->shouldReceive('getAttribute')->andReturn('categories');
        $mock->shouldReceive('getRouteKey')->andReturn('category-id');
    });

    $document = Document::type('articles')
        ->id('article-id')
        ->attributes(['title' => 'Article title'])
        ->relationshipsData([
            'category' => $category
        ])
        ->toArray();

    $expected = [
        'data' => [
            'type' => 'articles',
            'id' => 'article-id',
            'attributes' => [
                'title' => 'Article title'
            ],
            'relationships' => [
                'category' => [
                    'data' => [
                        'type' => "categories",
                        'id' => 'category-id'
                    ]
                ]
            ]
        ]
    ];

    expect($expected)->toEqual($document);
});
