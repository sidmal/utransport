# uTransport - is simple cURL transport for PHP

uTransport can send HTTP requests for any urls by post and get methods.

## Install

```bash
composer require sidmal/utransport
```
    
## Basic Usage

    ```php
    <?php
    
    use UTransport\AbstractProvider;
    use UTransport\Transport\BasicAuth;
    use UTransport\Transport\Request;
    
    /**
    * BasicAuth object contain data for HTTP basic authorization on the request url.
    **/
    $basicAuth = new BasicAuth('username', 'password');

    $request = (new Request())
        ->setUrl($url)
        ->setMethod(Request::METHOD_POST)
        ->setBasicAuth($basicAuth);
    
    $provider = new AbstractProvider();
    
    /**
    * Do HTTP request and get Response object.
    * Response object contain data which received from requested url.
    **/
    $response = $provider->doRequest($request);
    
    /**
    *  Get RequestLog object which contain information about last HTTP request.
    **/
    $log = $provider->getTransport()->getLog();
    ```