<?php

namespace App\Http;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\Response as IlluminateResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    /**
     * [$statusCode description]
     * @var [type]
     */
    protected $statusCode = Response::HTTP_OK;

    /**
     * [getStatusCode description]
     * @return [type] [description]
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * [setStatusCode description]
     * @param [type] $statusCode [description]
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * [respondUnauthorized description]
     * @param  string $message [description]
     * @return [type]          [description]
     */
    public function respondUnauthorized($message = 'Unauthorized!')
    {
        return $this->setStatusCode(Response::HTTP_UNAUTHORIZED)
                    ->respondWithError($message);
    }

    /**
     * [respondNotFound description]
     * @param  string $message [description]
     * @return [type]          [description]
     */
    public function respondNotFound($message = 'Not Found!')
    {
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)
                    ->respondWithError($message);
    }

    /**
     * [respondUnprocessableEntity description]
     * @param  string $message [description]
     * @return [type]          [description]
     */
    public function respondUnprocessableEntity($message = 'UnprocessableEntity!')
    {
        return $this->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)
                    ->respondWithError($message);
    }

    /**
     * [respondNotFound description]
     * @param  string $message [description]
     * @return [type]          [description]
     */
    public function respondInternalError($message = 'Internal Error!')
    {
        return $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)
                    ->respondWithError($message);
    }

    /**
     * [respondCreated description]
     * @param  string $message [description]
     * @return [type]          [description]
     */
    public function respondCreated($message, $location)
    {
        return $this->setStatusCode(Response::HTTP_CREATED)
                    ->respond(['message' => $message],
                        ['Location' => $location]);
    }

    public function respondNoContent()
    {
        return $this->setStatusCode(Response::HTTP_NO_CONTENT)
                    ->respond();
    }

    /**
     * [respondWithPagination description]
     * @param  Paginator $collection [description]
     * @param  [type]    $data       [description]
     * @return [type]                [description]
     */
    public function respondWithPagination(Paginator $collection, $data)
    {
        return $this->respond($data, [
            'X-Total-Count' => $collection->total(),
            'Link' => $this->buildHeaderLinks($collection)
        ]);
    }

    /**
     * [respond description]
     * @param  [type] $data    [description]
     * @param  array  $headers [description]
     * @return [type]          [description]
     */
    public function respond($data = null, $headers = [])
    {
        return IlluminateResponse::json($data, $this->getStatusCode(), $headers);
    }

    /**
     * [respondWithError description]
     * @param  [type] $message [description]
     * @return [type]          [description]
     */
    public function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode()
            ]
        ]);
    }

    /**
     * [buildHeaderLinks description]
     * @param  Paginator $collection [description]
     * @return [type]                [description]
     */
    private function buildHeaderLinks(Paginator $collection)
    {
        $links = array();

        if ($collection->nextPageUrl()) {
            $links[] = $this->buildHeaderLink('next', $collection->nextPageUrl(), $collection->perPage());
        }

        if ($collection->previousPageUrl()) {
            $links[] = $this->buildHeaderLink('prev', $collection->previousPageUrl(), $collection->perPage());
        }

        $links[] = $this->buildHeaderLink('first', $collection->url(1), $collection->perPage());
        $links[] = $this->buildHeaderLink('last', $collection->url($collection->lastPage()), $collection->perPage());

        return join($links, ", ");
    }

    /**
     * [buildHeaderLink description]
     * @param  [type] $rel     [description]
     * @param  [type] $link    [description]
     * @param  [type] $perPage [description]
     * @return [type]          [description]
     */
    private function buildHeaderLink($rel, $link, $perPage)
    {
        return '<'.$link.'&per_page='.$perPage.'>; rel="'.$rel.'"';
    }
}