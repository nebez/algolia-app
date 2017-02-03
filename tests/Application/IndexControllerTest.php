<?php

namespace Tests\Application;

use Tests\Helpers\ApplicationTestCase;
use App\Contracts\ItemIndexer;

class IndexControllerTest extends ApplicationTestCase {

    public function setUp()
    {
        parent::setUp();

        $this->app->bind(ItemIndexer::class)->to(FakeItemIndexer::class);
    }

    public function testThatSearchTermsWork()
    {
        $this->visit('/api/1/apps/search?q=test')
            ->status(200)
            ->seeJson(['term' => 'test']);
    }

    public function testThatMissingSearchTermsThrow()
    {
        $this->visit('/api/1/apps/search')
            ->status(400)
            ->containsString('Missing search');
    }

    public function testThatBatchAppCreationWorks()
    {
        $this->post('/api/1/apps/batch')
            ->status(200)
            ->containsString('iBooks')
            ->containsString('Marvel Comics');
    }

    public function testThatCreatingAppsWorks()
    {
        $app = [
            'id' => 123456,
            'name' => 'Algolia Searcher',
            'image' => 'http://images.local/image.png'
        ];

        $this->post('/api/1/apps', $app)
            ->status(200)
            ->containsString('123456');
    }

    public function testThatDeletingAppsWorks()
    {
        $this->delete('/api/1/apps/999')
            ->status(200)
            ->seeJson(['action' => 'delete', 'id' => '999']);
    }
}

class FakeItemIndexer implements ItemIndexer {
    public function add(array $items)
    {
        return $items;
    }

    public function delete($id)
    {
        return $id;
    }

    public function clear()
    {
        return null;
    }

    public function search($term)
    {
        return ['term' => $term];
    }
}
