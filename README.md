# filter bad words from your php string

Safewords is a package that can be used in any PHP framework, calling in a static method and returning the censored text or a boolean to know if is safe. 

## Support me staring this repository or connecting with me in [linkedin](https://www.linkedin.com/in/matheusfares/)

## Installation

You can install the package via composer: 

```
composer require faresmts/safewords
```

## Usage

This is the simplest way to call a safewords checker: 
```
$isSafe = SafeWords::filter($text)
            ->isSafe()
            ->get();
```
And this is the way to call a safewords censor:
```
$isSafe = SafeWords::filter($text)
            ->replace()
            ->get();
```

### filter() ->





