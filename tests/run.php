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

function qpjRunProbe($script)
{
    $probe = tempnam(sys_get_temp_dir(), 'qpj');
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

function qpjStatusPrefix()
{
    return "<?php\n"
        . "http_response_code(200);\n"
        . "register_shutdown_function(function () {\n"
        . "    fwrite(STDOUT, \"\\nSTATUS=\" . http_response_code());\n"
        . "});\n";
}

function qpjCaptureStatus($phpCode)
{
    $root = dirname(__DIR__);
    $script = qpjStatusPrefix()
        . "require "
        . var_export($root . DIRECTORY_SEPARATOR . 'functions.inc2.php', true)
        . ";\n"
        . $phpCode
        . "\n";
    return qpjRunProbe($script);
}

function qpjCaptureInclude($setupPhp, $relativeFile)
{
    $root = dirname(__DIR__);
    $script = qpjStatusPrefix()
        . "chdir(" . var_export($root, true) . ");\n"
        . $setupPhp . "\n"
        . "include " . var_export($relativeFile, true) . ";\n";
    return qpjRunProbe($script);
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
