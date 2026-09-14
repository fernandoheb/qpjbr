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

function qpjCaptureStatus($phpCode)
{
    $root = dirname(__DIR__);
    $probe = tempnam(sys_get_temp_dir(), 'qpj');
    $script = "<?php\n"
        . "http_response_code(200);\n"
        . "register_shutdown_function(function () {\n"
        . "    fwrite(STDOUT, \"\\nSTATUS=\" . http_response_code());\n"
        . "});\n"
        . "require "
        . var_export($root . DIRECTORY_SEPARATOR . 'functions.inc2.php', true)
        . ";\n"
        . $phpCode
        . "\n";
    file_put_contents($probe, $script);
    $cmd = escapeshellarg(PHP_BINARY)
        . ' -d display_errors=0 '
        . escapeshellarg($probe);
    $lines = array();
    exec($cmd, $lines);
    @unlink($probe);
    $text = implode("\n", $lines);
    if (preg_match('/STATUS=(\\d+)/', $text, $match)) {
        return intval($match[1]);
    }
    return 0;
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
