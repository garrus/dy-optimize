<?php
/**
 * Created by PhpStorm.
 * User: garrus
 * Date: 2017/11/5 0005
 * Time: 下午 9:13
 */
$file = 'data-in-live.js';
$content = file_get_contents($file);

$ret = count_chars($content);
$chars = array_filter($ret);
arsort($chars);
printf('There are %d kind of chars in length %d'. PHP_EOL,
    count($chars),
    strlen($content)
);
printf('After press by gzdeflate(### 1): %d. Percentage gain: %.1f%%.'. PHP_EOL,
    strlen($compress = gzdeflate($content, 1)),
    100 * strlen($content)/strlen($compress)
);
foreach ($chars as $charCode => $count) {
     printf("%c\t=>\t%d (%d)\n", $charCode, $count, $charCode);
}

echo str_word_count($content), PHP_EOL;

$words = preg_split('/[^a-zA-Z0-9_\.-]/', $content, -1, PREG_SPLIT_NO_EMPTY);
print_r(count($words));

$wordStat = [];
foreach ($words as $word) {
    if (strlen($word) < 3) continue;
    if (!isset($wordStat[$word])) {
        $wordStat[$word] = 1;
    } else {
        $wordStat[$word]++;
    }
}

$new = [];
foreach ($wordStat as $word => $count) {
    $new[] = [$word, $count];
}
usort($new, function($a, $b){
    return $b[1] === $a[1] ? (strlen($b[0]) - strlen($a[0])) : ($b[1] - $a[1]);
});

$i = 1;
foreach ($new as list($word, $count)) {
    printf("%3d# %s\t=>\t%d\n", $i++, $word, $count);
    if ($i > 160) break;
}

$charList = [];
foreach (range(1, 255) as $charCode) {
    if (!in_array($charCode, [10,13])
        && !($charCode >= 32 && $charCode <=126)
    ) {
        $charList[] = chr($charCode);
    }
}

$charMap = [];
$_c = $content;
foreach ($new as $index => list($word, $count)) {
    if (isset($charList[$index])) {
        $char = $charList[$index];
        $charMap[$char] = $word;
        $_c = str_replace($word, $char, $_c);
    }
}
printf('%d, %d, %.1f%%'. PHP_EOL, strlen($content), strlen($_c),100 *strlen($content) / strlen($_c));

$_cc = gzdeflate($_c, 1);
printf('%d, %d, %.1f%%'. PHP_EOL, strlen($content), strlen($_cc),100 *strlen($content) / strlen($_cc));


