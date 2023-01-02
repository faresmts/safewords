<?php

namespace Faresmts\SafeWords;

use Faresmts\SafeWords\Exceptions\InvalidMethodCall;

class SafeWords
{
    protected array $text;

    protected bool $isSafe = true;

    protected array $badWords;

    protected array $leet;

    protected array $charsWithAccents;

    protected array $charsWithoutAccents;

    protected string $safeText;

    protected array $userBadWords = [];

    protected bool $usingExternalBadWords;

    protected bool $verify = false;

    protected bool $replace = false;

    public static function filter(string $text): self
    {
        return (new static($text));
    }

    public function __construct(string $text)
    {
        $this->badWords = (array) include 'Resources/BadWords.php';
        $this->leet = (array) include 'Resources/Leet.php';
        $this->charsWithAccents = (array) include 'Resources/CharsWithAccents.php';
        $this->charsWithoutAccents = (array) include 'Resources/CharsWithoutAccents.php';

        $textWhitoutAccent = $this->removeAccent($text);
        $unleetText = $this->leetTransform($textWhitoutAccent);
        $this->text = explode(' ', $unleetText);
    }

    public function replace(string $replace = '*'): self
    {
        if ($this->verify) {
            throw InvalidMethodCall::thisMethodCallIsNotValid();
        }

        $this->replace = true;

        foreach ($this->text as $key => $word) {
            if (in_array($word, $this->badWords) || in_array($word, $this->userBadWords)) {
                $replaceAmount = strlen($word);
                $fullReplace = '';

                for ($i = 0; $i < $replaceAmount; $i++) {
                    $fullReplace = $fullReplace . $replace ;
                }

                $safeWord = str_replace($word, $fullReplace, $word);
                $this->text[$key] = $safeWord;
            }
        }

        $this->safeText = implode(' ', $this->text);

        return $this;
    }

    public function isSafe(): self
    {
        if ($this->replace) {
            throw InvalidMethodCall::thisMethodCallIsNotValid();
        }

        $this->verify = true;

        foreach ($this->text as $word) {
            if (in_array($word, $this->badWords) || in_array($word, $this->userBadWords)) {
                $this->isSafe = false;
            }
        }

        return $this;
    }

    public function useDictionary(array $userBadWords): self
    {
        if (! $this->verify && ! $this->replace) {
            $this->userBadWords = $userBadWords;

            return $this;
        }

        throw InvalidMethodCall::useDictionaryAfterVerifyOrReplace();
    }

    public function get(): bool | string
    {
        return $this->verify ? $this->isSafe : $this->safeText;
    }

    private function leetTransform(string $text): string
    {
        foreach ($this->leet as $leet => $letterEquivalent) {
            $text = str_replace($leet, $letterEquivalent, $text);
        }

        return $text;
    }

    private function removeAccent(string $text): string
    {
        return str_replace($this->charsWithAccents, $this->charsWithoutAccents, $text);
    }
}
