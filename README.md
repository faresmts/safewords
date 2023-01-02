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
$censoredText = SafeWords::filter($text)
                   ->replace()
                   ->get();
```

Both methods can be called with useDictionary() function to add new words to block:
```
$isSafe = SafeWords::filter($text)
            ->useDictionary(['foo', 'bar'])
            ->isSafe()
            ->get();

$censoredText = SafeWords::filter($text)
                    ->useDictionary(['foo', 'bar'])
                    ->replace()
                    ->get();

```

### Functions

`filter(string $text)`: add the text you want to check.

`useDictionary(array $userBadWords)`: add the words you want to block in SafeWords checker. 

`isSafe()`: method that evaluates whether the text is safe.

`replace(string $replace = '*')`: method that replaces each character of the bad word with the variable inside $string. Default is '*'.

`get()`: get the result of the chosen method.

### Exceptions

- The methods `isSafe()` and `replace()` cannot be called at the same time, throwing an exception if this happens.

- The method `useDictionary()` cannot be called after the `isSafe()` or `replace()`. It must be called before. 






