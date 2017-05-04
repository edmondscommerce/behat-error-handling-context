# Behat Error Handling Context
## By [Edmonds Commerce](https://www.edmondscommerce.co.uk)

Used to handle simple errors and to take screenshots when they occur

### Installation

Install via composer

"edmondscommerce/behat-error-handling-context": "~1.0"


### Include Context in Behat Configuration

```
default:
    # ...
    suites:
        default:
            # ...
            contexts:
                - # ...
                - EdmondsCommerce\BehatErrorHandling\ErrorHandlingContext

```
