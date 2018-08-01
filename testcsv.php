<?php
$fh = fopen('D:/GitHub/Python/data2.csv', 'rb');
if (! $fh) {
    die("Can't open csvdata.csv: $php_errormsg");
}
/* http://www.manongjc.com/article/1308.html */
print "<table>\n";
       
for ($line = fgetcsv($fh, 1024); ! feof($fh); $line = fgetcsv($fh, 1024)) {
    print '<tr><td>' . implode('</td><td>', $line) . "</td></tr>\n";
}

print '</table>';
?>