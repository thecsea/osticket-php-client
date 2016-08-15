# osticket-php-client
[![Latest Stable Version](https://poser.pugx.org/thecsea/osticket-php-client/v/stable)](https://packagist.org/packages/thecsea/osticket-php-client) [![Total Downloads](https://poser.pugx.org/thecsea/osticket-php-client/downloads)](https://packagist.org/packages/thecsea/osticket-php-client) [![Latest Unstable Version](https://poser.pugx.org/thecsea/osticket-php-client/v/unstable)](https://packagist.org/packages/thecsea/osticket-php-client) [![License](https://poser.pugx.org/thecsea/osticket-php-client/license)](https://packagist.org/packages/thecsea/osticket-php-client)



Rest php client for [osticket](http://osticket.com/)

## Features
### Ositcket features

- [x] Creation of tickets
- [ ] Attachments
- [ ] Execution of cron

### Other/TODO
- [ ] Unit tests
- [ ] Laravel integration
- [x] Load data by env
- [ ] PHP doc
- [ ] Force HTTPS
- [ ] Better HTTPS status code manage (for example 303 and other 2xx)
- [ ] Travis scrutinizer integration
- [ ] Usage guide and wiki

## Examples

### Create a ticket
```php
use it\thecsea\osticket_php_client\OsticketPhpClient;
use it\thecsea\osticket_php_client\OsticketPhpClientException;

$support = new OsticketPhpClient($url, $apiKey);
try{
  $response = $client->newTicket()
              ->withName('test')
              ->withEmail('test@test.com')
              ->withPhone('0123456789')
              ->withSubject('subject')
              ->withMessage('message')
              ->withTopicId('1')
              ->getData();
  print $response;
}catch(OsticketPhpClientException $e){
  print $->getMessage();
}
```
Of course you can perform the request without inserting all fields.  
You can also use *withData* method passing and array of data that is merged with the data set previously or with the defaut data
