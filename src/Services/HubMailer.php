<?php

namespace Sevengroup\HubscoreBundle\Services;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HubMailer
{
    private ?string $apiUrl;
    private ?string $apiVersion;
    private ?array $endpoints;
    private HttpClientInterface $httpClient;
    private ?string $token;

    public function __construct(
      ParameterBagInterface $parameterBag,
      HttpClientInterface $httpClient
    )
    {
        $this->apiUrl = $parameterBag->get('sevengroup_hubscore.api_url');
        $this->apiVersion = $parameterBag->get('sevengroup_hubscore.api_version');
        $this->endpoints = $parameterBag->get('sevengroup_hubscore.endpoints');
        $this->httpClient = $httpClient;
    }

    public function connection(string $username, string $password): array
    {
        $response = $this->httpClient->request(
          'POST', 
          $this->apiUrl . $this->endpoints['login'], 
          [
            'json' => [
                'Username' => $username,
                'Password' => $password,
            ]
          ]
        );

        if($response->getStatusCode() !== 200) {
          throw new \RuntimeException('API request failed: ' . $response->getContent());
        }

        $res = $response->toArray();
        
        if(array_key_exists('token', $res)) {
          $this->setToken($res['token']);
        }

        return $res;
    }

    public function list(string $endpoint, array $data = []): array
    {
      if(array_key_exists($endpoint, $this->endpoints) && array_key_exists('list', $this->endpoints[$endpoint])) {
        return $this->sendRequest('GET', $this->endpoints[$endpoint]['list'], $data);
      } else {
        throw new \RuntimeException('Endpoint not found');
      }
    }

    public function get(string $endpoint, int $id, array $data = []): array
    {
      if(array_key_exists($endpoint, $this->endpoints) && array_key_exists('get', $this->endpoints[$endpoint])) {
        return $this->sendRequest('GET', str_replace('{id}', $id, $this->endpoints[$endpoint]['get']), $data);
      } else {
        throw new \RuntimeException('Endpoint not found');
      }
    }

    public function post(string $endpoint, array $data = []): array
    {
      if(array_key_exists($endpoint, $this->endpoints) && array_key_exists('post', $this->endpoints[$endpoint])) {
        return $this->sendRequest('POST', $this->endpoints[$endpoint]['post'], $data);
      } else {
        throw new \RuntimeException('Endpoint not found');
      }
    }

    public function put(string $endpoint, int $id, array $data = []): array
    {
      if(array_key_exists($endpoint, $this->endpoints) && array_key_exists('put', $this->endpoints[$endpoint])) {
        return $this->sendRequest('PUT', str_replace('{id}', $id, $this->endpoints[$endpoint]['put']), $data);
      } else {
        throw new \RuntimeException('Endpoint not found');
      }
    }

    public function delete(string $endpoint, int $id, array $data = []): array
    {
      if(array_key_exists($endpoint, $this->endpoints) && array_key_exists('delete', $this->endpoints[$endpoint])) {
        return $this->sendRequest('DELETE', str_replace('{id}', $id, $this->endpoints[$endpoint]['delete']), $data);
      } else {
        throw new \RuntimeException('Endpoint not found');
      }
    }

    public function send(string $endpoint = 'campaign', array $data = []): array
    {
      if(array_key_exists($endpoint, $this->endpoints) && array_key_exists('send', $this->endpoints[$endpoint])) {
        return $this->sendRequest('POST', $this->endpoints[$endpoint]['send'], $data);
      } else {
        throw new \RuntimeException('Endpoint not found');
      }
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * Generic method to send an HTTP request
     */
    private function sendRequest(string $method, string $endpoint, array $data = [], array $headers = null): array
    {
        $url = $this->apiUrl . '/' . $this->apiVersion . $endpoint;

        if ($headers === null) {
            $headers = [];
        }

        if($this->token === null) {
          throw new \RuntimeException('Token not set, please use the connection method or setToken method');
        }

        if(!array_key_exists('Authorization', $headers)) {
          $headers['Authorization'] = 'Bearer ' . $this->token;
        }

        try {
            $response = $this->httpClient->request($method, $url, [
                'headers' => $headers,
                'json' => $data,
            ]);

            return $response->toArray(); // Returns the decoded response body
        } catch (\Exception $e) {
            throw new \RuntimeException('API request failed: ' . $e->getMessage());
        }
    }
}