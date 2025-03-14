<?php
function calculateHalsteadMetrics($code) {
    $operators = [];
    $operands = [];
    $operatorCount = 0;
    $operandCount = 0;

    // Tokenize the code
    $tokens = token_get_all($code);

    foreach ($tokens as $token) {
        if (is_array($token)) {
            [$tokenType, $tokenValue] = $token;

            // Operators (using numeric token values)
            if ($tokenType === 277 || // T_PLUS_EQUAL
                $tokenType === 276 || // T_MINUS_EQUAL
                $tokenType === 275 || // T_MUL_EQUAL
                $tokenType === 274 || // T_DIV_EQUAL
                $tokenType === 272 || // T_MOD_EQUAL
                $tokenType === 271 || // T_EQUAL
                $tokenType === 260 || // T_DOUBLE_ARROW
                $tokenType === 279 || // T_BOOLEAN_AND
                $tokenType === 278) { // T_BOOLEAN_OR
                $operators[$tokenValue] = ($operators[$tokenValue] ?? 0) + 1;
                $operatorCount++;
            }
            // Operands (variables, constants, etc.)
            elseif ($tokenType === 309 || // T_VARIABLE
                    $tokenType === 307) { // T_STRING
                $operands[$tokenValue] = ($operands[$tokenValue] ?? 0) + 1;
                $operandCount++;
            }
        }
    }

    // Halstead's metrics
    $n1 = count($operators); // Number of distinct operators
    $n2 = count($operands);  // Number of distinct operands
    $N1 = $operatorCount;    // Total number of operators
    $N2 = $operandCount;     // Total number of operands

    // Program vocabulary
    $n = $n1 + $n2;
    // Program length
    $N = $N1 + $N2;
    // Volume
    $V = $N * log($n, 2);
    // Difficulty
    $D = ($n1 / 2) * ($N2 / $n2);
    // Effort
    $E = $D * $V;

    return [
        "n1" => $n1,
        "n2" => $n2,
        "N1" => $N1,
        "N2" => $N2,
        "n" => $n,
        "N" => $N,
        "V" => $V,
        "D" => $D,
        "E" => $E
    ];
}

$code = <<<'CODE'
<?php
function add($a, $b) {
    return $a + $b;
}

function subtract($a, $b) {
    return $a - $b;
}
CODE;

$metrics = calculateHalsteadMetrics($code);
echo "Halstead's Metrics:\n";
foreach ($metrics as $key => $value) {
    echo "$key: $value\n";
}
?>