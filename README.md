
## Requirements

- Docker

---

## Running tests

```shell
docker-compose up -d
docker exec currency_converter_php bash -c 'composer install && vendor/bin/phpunit --testdox'
```

--- 

## Notes

* Did not implement assigning ids properly
* If I worked on it during daytime would've asked if it fee should be taken before or after conversion as the task didn't clarify it
