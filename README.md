# Project to transactions

## Install
```bash
$ docker-compose up
```

## Others commands

* Coverage
```bash
$ docker-compose exec phpfpm php /usr/bin/composer.phar test-coverage
```

Tests
```bash
$ docker-compose exec phpfpm php /usr/bin/composer.phar test
```

## Folders

```
├── Business                                    # Classes business
│   ├── Account.php
│   ├── Model
│   │   ├── AccountInterface.php
│   │   ├── AuthorizationInterface.php
│   │   ├── ModelInterface.php
│   │   ├── TransactionInterface.php
│   │   └── WalletInterface.php
│   ├── Transaction.php
│   └── Wallet.php
├── Events                                      # Events
│   ├── Event.php
│   └── TransactionEvent.php
├── Exceptions
│   └── Handler.php
├── Http
│   ├── Controllers                             # Controllers
│   │   ├── AccountController.php
│   │   ├── Controller.php
│   │   └── TransactionController.php
│   └── Inputs                                  # Request Inputs
│       ├── AccountInput.php
│       ├── InputAbstract.php
│       ├── InputInterface.php
│       ├── TransactionCreditInput.php
│       └── TransactionInput.php
├── Listeners                                   # Listeners
│   ├── NotificationListener.php
│   └── NotificationProvider
│       ├── Http
│       │   └── NotificationProviderHttp.php
│       └── NotificationProviderInterface.php
├── Models                                      # Models
│   ├── Account.php
│   ├── Authorization.php
│   ├── Transaction.php
│   └── Wallet.php
├── Providers                                   # Providers
│   ├── EventServiceProvider.php
│   └── Http
│       ├── AdapterProviderHttp.php
│       └── AdapterProviderInterface.php
├── Repository                                  # Repositories
│   ├── AccountRepository.php
│   ├── AuthorizationRepository.php
│   ├── TransactionRepository.php
│   └── WalletRepository.php
└── Services                                    # Services
    ├── AccountService.php
    ├── AuthorizationProvider
    │   ├── AuthorizationProviderInterface.php
    │   └── Http
    │       └── AuthorizationProviderHttp.php
    ├── AuthorizationService.php
    ├── TransactionService.php
    └── WalletService.php

```


## Arctethure


## Routes

### Create account
POST /account
```js
{
    "name": "FULL NAME",
    "document": "14253678955",
    "email": "email@email.com",
    "type": "business" # person or business
}
```

### Added funds to account wallet
POST /transaction/credit
```js
{
    "value" : 100,
    "payer" : 1      # Account ID
}
```

### Execute transaction
POST /transaction
```js
{
    "value" : 100,
    "payer" : 1,    # Account ID
    "payee" : 2     # Account ID
}
```
