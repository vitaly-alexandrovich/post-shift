<?php namespace PostShift;

use HttpClient\Request;
use PostShift\Exceptions\ApiException;
use PostShift\Exceptions\IncorrectResponseException;
use PostShift\Exceptions\ServerErrorException;
use PostShift\Responses\GetMailResponse;
use PostShift\Responses\LiveTimeResponse;
use PostShift\Responses\MailItem;
use PostShift\Responses\NewResponse;

/**
 * Class Client
 * @package PostShift
 */
class Client
{
    const API_ENDPOINT = 'https://post-shift.ru/api.php';

    protected $proxy = null;

    /**
     * @param null $name
     * @return NewResponse
     * @throws ApiException
     * @throws IncorrectResponseException
     * @throws ServerErrorException
     */
    public function newMail($name = null)
    {
        $params = [];
        if (!is_null($name)) {
            $params['name'] = $name;
        }

        return NewResponse::fromArray($this->request('new', $params));
    }

    /**
     * @param $key
     * @return array|MailItem[]
     * @throws ApiException
     * @throws IncorrectResponseException
     * @throws ServerErrorException
     */
    public function getList($key)
    {
        try {
            $list = $this->request('getlist', ['key' => $key]);
        } catch (ApiException $e) {
            if ($e->getMessage() === 'the_list_is_empty') {
                // Если писем на почте нет - возвращаем пустой массив вместо исключения с ошибкой
                return [];
            }

            throw $e;
        }

        return array_map(function ($item) {
            return MailItem::fromArray($item);
        }, $list);
    }

    /**
     * @param $id
     * @param $key
     * @return GetMailResponse
     * @throws ApiException
     * @throws IncorrectResponseException
     * @throws ServerErrorException
     */
    public function getMail($id, $key)
    {
        return GetMailResponse::fromArray($this->request('getmail', ['id' => $id, 'key' => $key]));
    }

    /**
     * @param $key
     * @return LiveTimeResponse
     * @throws ApiException
     * @throws IncorrectResponseException
     * @throws ServerErrorException
     */
    public function livetime($key)
    {
        return LiveTimeResponse::fromArray($this->request('livetime', ['key' => $key]));
    }

    /**
     * @param $key
     * @return LiveTimeResponse
     * @throws ApiException
     * @throws IncorrectResponseException
     * @throws ServerErrorException
     */
    public function update($key)
    {
        return LiveTimeResponse::fromArray($this->request('livetime', ['key' => $key]));
    }

    /**
     * @param $key
     * @return bool
     * @throws ApiException
     * @throws IncorrectResponseException
     * @throws ServerErrorException
     */
    public function delete($key)
    {
        $response = $this->request('delete', ['key' => $key]);
        return isset($response['delete']) && $response['delete'] === 'ok';
    }

    /**
     * @param $key
     * @return bool
     * @throws ApiException
     * @throws IncorrectResponseException
     * @throws ServerErrorException
     */
    public function deleteAll($key)
    {
        $response = $this->request('delete', ['key' => $key]);
        return isset($response['delete']) && $response['delete'] === 'ok';
    }

    /**
     * @param $key
     * @return bool
     * @throws ApiException
     * @throws IncorrectResponseException
     * @throws ServerErrorException
     */
    public function clear($key)
    {
        $response = $this->request('clear', ['key' => $key]);
        return isset($response['clear']) && $response['clear'] === 'ok';
    }

    /**
     * @param $proxy
     */
    public function setProxy($proxy)
    {
        $this->proxy = $proxy;
    }

    /**
     * @return string
     */
    public function hasProxy()
    {
        return !is_null($this->proxy);
    }

    /**
     * @return string
     */
    public function getProxy()
    {
        return $this->proxy;
    }

    /**
     * @param $action
     * @param array $params
     * @return array
     * @throws IncorrectResponseException
     * @throws ServerErrorException
     * @throws ApiException
     */
    protected function request($action, $params = [])
    {
        $query = http_build_query(array_merge($params, ['action' => $action]));

        $request = new Request(static::API_ENDPOINT . '?' . $query . '&type=json');

        if ($this->hasProxy()) {
            $request->setProxy($this->getProxy());
        }
        
        $client = new \HttpClient\Client();
        
        $response = $client->sendRequest($request);

        if ($response->getCode() !== 200) {
            throw new ServerErrorException();
        }

        $responseData = json_decode($response->getBody(), true);

        if (!$responseData) {
            throw new IncorrectResponseException();
        }

        if (isset($responseData['error'])) {
            throw new ApiException($responseData['error']);
        }

        return $responseData;
    }


}