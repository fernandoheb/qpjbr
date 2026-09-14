<?php
$qpjPassed = 0;
$qpjFailed = 0;
$qpjTests = 0;

function qpjFail($message)
{
    global $qpjFailed, $qpjTests;
    $qpjTests++;
    $qpjFailed++;
    fwrite(STDERR, 'FAIL: ' . $message . PHP_EOL);
}

function qpjPass()
{
    global $qpjPassed, $qpjTests;
    $qpjTests++;
    $qpjPassed++;
}

function assertTrue($condition, $message = '')
{
    if ($condition) {
        qpjPass();
        return;
    }
    qpjFail($message === '' ? 'assertTrue failed' : $message);
}

function assertSame($expected, $actual, $message = '')
{
    if ($expected === $actual) {
        qpjPass();
        return;
    }
    $detail = $message === '' ? '' : $message . ': ';
    qpjFail(
        $detail
        . 'expected ' . var_export($expected, true)
        . ' got ' . var_export($actual, true)
    );
}


$files = glob(__DIR__ . DIRECTORY_SEPARATOR . '*_test.php');
sort($files);
foreach ($files as $file) {
    require $file;
}

echo 'Tests: ' . $qpjTests
    . ' passed: ' . $qpjPassed
    . ' failed: ' . $qpjFailed
    . PHP_EOL;

exit($qpjFailed === 0 ? 0 : 1);
