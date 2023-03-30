<?php
/* 
  В данном упражнении необходимо реализовать стековую машину, то есть алгоритм, проводящий вычисления по обратной польской записи.
Обратная польская нотация или постфиксная нотация — форма записи математических и логических выражений, 
в которой операнды расположены перед знаками операций. Выражение читается слева направо. 
Когда в выражении встречается знак операции, выполняется соответствующая операция над двумя ближайшими операндами, 
находящимися слева от знака операции. Результат операции заменяет в выражении последовательность её операндов и знак, 
после чего выражение вычисляется дальше по тому же правилу. Таким образом, результатом вычисления всего выражения становится 
результат последней вычисленной операции.

  Например, выражение (1 + 2) * 4 + 3 в постфиксной нотации будет выглядеть так: 1 2 + 4 * 3 +, а результат вычисления: 15. 
Другой пример - выражение: 7 - 2 * 3, в постфиксной нотации: 7 2 3 * -, результат: 1.

  Реализуйте функцию calcInPolishNotation, которая принимает массив, каждый элемент которого содержит число или знак операции (+, -, *, /). 
Функция должна вернуть результат вычисления по обратной польской записи.
*/

function calcInPolishNotation($inString)
{
    $operators = ['+', '-', '*', '/'];
    try {
        $myString = preg_replace('/\s+/', ' ', trim($inString));

        if (!$myString) {
            throw new DomainException('Ошибка! Пустое выражение!');
        }
        preg_match('/[^\s\d+\/*-]+/', $myString, $matches);
        if ($matches) {
            throw new DomainException("Ошибка! Допустимы только цифры, и операторы '+, -, *, /.'");
        }
        $arr = explode(" ", $myString);
        $stack = [];


        foreach ($arr as $item) {
            if (!in_array($item, $operators )) {
                array_push($stack, $item);
            } else {
                $operand = $item;
                $b = array_pop($stack) ?? null;
                $a = array_pop($stack) ?? null;
                if ($b === null || $a === null) {
                    throw new DomainException('Ошибка! Неверное выражение! Мало цифр.');
                }
                array_push($stack, operation($a, $b, $operand));
            }
        }

        if (count($stack) > 2) {
            throw new DomainException('Ошибка! Неверное выражение! Мало операторов.');
        }
        $result = array_pop($stack);
        return $result;

    } catch (Exception $e) {
        return $e->getMessage() . " Входящее выражение (" . $inString . ")";
    }
}
function operation($a, $b, $operand)
{
    switch ($operand){
        case '+':
            $result=$a+$b;
            break;
        case '-':
            $result=$a-$b;
            break;
        case '*':
            $result=$a*$b;
            break;
        case '/':
            if ($b == 0) {
                throw new DomainException('Ошибка! Деление на ноль!');
            }
            $result=$a/$b;
            break;
        default:
            throw new DomainException('Ошибка! Неизвестный оператор ' . $operand);
    }
    //unset($operand);
    return $result;
}

//echo '<pre>';

print_r (calcInPolishNotation("1 2 3 4 5 - -") . PHP_EOL);
print_r (calcInPolishNotation("1 2 - -") . PHP_EOL);
print_r (calcInPolishNotation("5 3 ± 8 + *") . PHP_EOL);
print_r (calcInPolishNotation("Hello world") . PHP_EOL);
print_r (calcInPolishNotation("") . PHP_EOL);
print_r (calcInPolishNotation("  ") . PHP_EOL);
print_r (calcInPolishNotation("5 3 + 8 *") . PHP_EOL);
print_r (calcInPolishNotation("5 7 + 0 /") . PHP_EOL);
print_r (calcInPolishNotation("4 6 5 2 * / - 10 +") . PHP_EOL);
print_r (calcInPolishNotation("4 62  +") . PHP_EOL);
print_r (calcInPolishNotation("4 -62  +") . PHP_EOL);
print_r (calcInPolishNotation("6 9 + 5 - 8 1 8 * + / 7 +") . PHP_EOL);
//echo '<pre>';
