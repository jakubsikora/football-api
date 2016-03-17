<?php

use App\Document;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class DocumentsTest extends ApiTester
{
    /** @test */
    public function it_fetches_documents()
    {
        factory(Document::class, 3)->create();

        $this->getJson('api/v1/documents');

        $this->assertResponseOk();
    }

    /** @test */
    public function it_fetches_single_document()
    {
        factory(Document::class)->create();

        $document = $this->getJson('api/v1/documents/1')->data;

        $this->assertResponseOk();
        $this->assertObjectHasAttributes($document, 'name', 'type');
    }

    /** @test */
    public function it_404s_if_a_document_is_not_found()
    {
        $json = $this->getJson('api/v1/documents/x');

        $this->assertResponseStatus(404);
        $this->assertObjectHasAttributes($json, 'error');
    }

    /** @test */
    public function it_creates_a_new_document_given_valid_parameters()
    {
        $this->getJson('api/v1/documents', 'POST', factory(Document::class, 1)->make()->toArray());

        $this->assertResponseStatus(201);
    }

    /** @test */
    public function it_throws_a_422_if_a_new_lesson_request_fails_validation()
    {
        $this->getJson('api/v1/documents', 'POST');

        $this->assertResponseStatus(422);
    }
}
