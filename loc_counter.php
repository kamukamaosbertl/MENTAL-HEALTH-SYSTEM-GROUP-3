<?php
function countLoc($filePath)
{
    $lines = file($filePath);
    $codeLines = 0;

    foreach ($lines as $line) {
        $line = trim($line);
        if (!empty($line) && !preg_match('/^\s*\/\//', $line) && !preg_match('/^\s*\/\*/', $line)) {
            $codeLines++;
        }
    }

    return $codeLines;
}

function countLocInProject($projectPath)
{
    $totalLoc = 0;
    $directory = new RecursiveDirectoryIterator($projectPath);
    $iterator = new RecursiveIteratorIterator($directory);

    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $totalLoc += countLoc($file->getPathname());
        }
    }

    return $totalLoc;
}

$projectPath = __DIR__; // Current directory, change if needed
$loc = countLocInProject($projectPath);
echo "Total Lines of Code (LOC): $loc\n";
?>