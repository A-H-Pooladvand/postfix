<?php

namespace App\Http\Src;

class Postfix extends PostfixHelper
{
    public function convert(string $expression)
    {
        $characters = $this->split($expression);

        foreach ($characters as $character) {
            $this->handle($character);
        }

        $this->unloadWord();

        // Pop all the remaining elements from the stack
        while ($this->stack->peek() !== false) {
            $this->output->push($this->stack->pop());
        }

        return $this->output->get();
    }

    private function handle(string $character)
    {
        $this->unloadWord();
        // 1. If the scanned character is an operand, output it.
        if ($this->isOperand($character)) {
            $this->addToWord($character);
            // 4. If the scanned character is an ‘(‘, push it to the stack.
        } elseif ($character === $this->openParentheses) {
            $this->pushOperator($character);
            // 5. If the scanned character is an ‘)’, pop the stack and and output it until a ‘(‘ is encountered, and discard both the parenthesis.
        } elseif ($character === $this->closeParentheses) {
            while ($this->stack->peek() !== false && $this->stack->peek() !== $this->openParentheses) {
                $this->output->push($this->stack->pop());
            }
            if ($this->stack->peek() === $this->openParentheses) {
                $this->stack->pop();
            }
            // If an operator is scanned
        } else {
            while ($this->stack->peek() !== false && $this->getPrecedence($character) <= $this->getPrecedence($this->stack->peek())) {
                $this->output->push($this->stack->pop());
            }
            $this->stack->push($character);
        }

    }
}