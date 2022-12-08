<?php
 
namespace Faresmts\SafeWords;

use Faresmts\SafeWords\Exceptions\InvalidMethodCall;

class SafeWords
{
    protected array $text;

    protected bool $isSafe = true;

    protected array $badWords;

    protected string $safeText;

    protected bool $verify = false;

    protected bool $replace = false;

    public static function filter(string $text): self
    {
        return (new static($text));
    }

    public function __construct (string $text)
    {   
        $this->text = explode(' ', $text);
        $this->badWords = (array) include 'BadWords.php';
    }

    public function replace(string $replace = '*'): self
    {
        if($this->verify){
            throw InvalidMethodCall::thisMethodCallIsNotValid();
        }
        
        $this->replace = true;

        foreach($this->text as $key => $word) {   
            
            if(in_array($word, $this->badWords)) {

                $replaceAmount = strlen($word);
                $fullReplace = '';
                
                for ($i = 0; $i < $replaceAmount; $i++){
                    $fullReplace = $fullReplace.$replace ;
                }

                $safeWord = str_replace($word, $fullReplace, $word);
                $this->text[$key] = $safeWord;
            }
        }   

        $this->safeText = implode(' ', $this->text);
        

        return $this;
    }

    public function verify(): self
    {
        if($this->replace){
            throw InvalidMethodCall::thisMethodCallIsNotValid();
        }

        $this->verify = true;

        foreach($this->text as $word) {  
            if(in_array($word, $this->badWords)) {
                $this->isSafe = false;
            }
        }

        return $this;
    }

    public function get(): bool | string
    {
        return $this->verify ? $this->isSafe : $this->safeText;
    }

}
