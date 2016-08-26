Codeception: TestingBot Extension
============================

This is a CodeCeption extension that will send test meta-data back to TestingBot.
This way, you can see the test name, passed/failed state and more in the TestingBot dashboard overview.

Installation
--------------

+ Add the testingbot/codeception-extension composer package to the project's composer.json or run
`composer require testingbot/codeception-extension`

+ Execute composer to update your environment.

+ Add the extension and your TestingBot credentials in the codeception.yml file:

```json
actor: Tester
paths:
    tests: tests
    log: tests/_output
    data: tests/_data
    support: tests/_support
    envs: tests/_envs
settings:
    bootstrap: _bootstrap.php
    colors: true
    memory_limit: 1024M
extensions:
    enabled:
        - Codeception\Extension\RunFailed
        - Codeception\Extension\TestingBotExtension
    config:
        Codeception\Extension\TestingBotExtension:
            key: "KEY"
            secret: "SECRET"
modules:
    config:
        Db:
            dsn: ''
            user: ''
            password: ''
            dump: tests/_data/dump.sql

````

+ Make sure your tests use the extension:

```json
modules:
  enabled:
    - \TestingBotWebDriver
  config:
    \TestingBotWebDriver:
      host: 'hub.testingbot.com'
      port: 80
      browser: chrome
      url: 'http://www.google.com'
      capabilities:
        'client_key': 'YOUR TESTINGBOT KEY'
        'client_secret' : 'YOUR TESTINGBOT SECRET'
        'build': 'codeception-testingbot'

env:
  single:
    modules:
      config:
        \TestingBotWebDriver:
          capabilities:
            'name': 'single_test'
```json


* The TestingBot `key` and `secret` are available in the [testingbot member area](https://testingbot.com/members/user/edit)

Refer to this documentation [here](http://codeception.com/docs/02-GettingStarted#Configuration) for further explanation.