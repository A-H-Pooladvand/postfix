<?php

namespace App\Http\Src;

use Stack\Stack;

class PostfixHelper
{
    protected $operators = [
        '^' => ['precedence' => '0'],
        '+' => ['precedence' => '1'],
        '-' => ['precedence' => '1'],
        '*' => ['precedence' => '2'],
        '/' => ['precedence' => '2'],
        '!' => ['precedence' => '3'],
    ];

    protected $openParentheses = '(';

    protected $closeParentheses = ')';

    protected $word;

    protected $output;

    protected $stack;

    public function __construct()
    {
        $this->stack = new Stack();

        $this->output = new Stack();
    }

    protected function split(string $expression): array
    {
        return str_split($expression);
    }

    protected function isOperator(string $character)
    {
        $operators = array_keys($this->operators);
        array_push($operators, $this->openParentheses);
        array_push($operators, $this->closeParentheses);

        return in_array($character, $operators);
    }

    protected function isOperand(string $character)
    {
        return ! $this->isOperator($character);
    }

    protected function addToWord(string $character): void
    {
        $this->word .= $character;
    }

    protected function pushOperator(string $operator)
    {
        $this->stack->push($operator);
    }

    protected function scannedOperatorIsBiggerThanStackOperator(string $scannedOperator, string $stackOperator = null)
    {
        if (is_null($stackOperator)) {
            return true;
        }

        if ($stackOperator === $this->openParentheses) {
            return true;
        }

        return $scannedOperator > $stackOperator;
    }

    protected function unloadWord()
    {
        if (null === $this->word) {
            return null;
        }

        $this->output->push($this->word);
        $this->word = null;
    }

    protected function getPrecedence(string $operator)
    {
        switch ($operator) {
            case '^':
                return 3;
                break;
            case '*':
            case '/':
            case '!':
                return 2;
                break;
            case '+':
            case '-':
                return 1;
                break;

            default:
                return -1;
        }
    }
}