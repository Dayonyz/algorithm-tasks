# Algorithm tasks

## Deploy

```
make build
make install
```

## Run and enter PHP container 

```
make start
make ssh
```

## Run tests before

```
make ssh
vendor/bin/phpunit --testsuite "Unit Tests"
```

# Technical requirements

1) Write a Fibonacci function that avoids memory overflow and reduces execution time.
- **Implemented in fibonacci.php file**
```
make ssh
vendor/bin/phpunit --filter FibonacciTest
```

2) Write a function that returns all max length arithmetic series.
- **Implemented in array.php file**
```
make ssh
vendor/bin/phpunit --filter LongestArithmeticSeriesTest
```

3) Write a function that counts top level domain unique urls.
- **Implemented in urls.php file**
```
make ssh
vendor/bin/phpunit --filter UniqueTopLevelDomainsUrlsCountTest
```

