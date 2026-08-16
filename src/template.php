<!doctype html>
<head>
    <title>WikiHiero HTML vs. SVG rendering comparison</title>
    <style>
        body {
            font-family: sans-serif;
        }

        .wikitable {
            background-color: #f8f9fa;
            margin: 1em 0;
            border: 1px solid #a2a9b1;
            border-collapse: collapse
        }

        .wikitable > tr > th,.wikitable > tr > td,.wikitable > * > tr > th,.wikitable > * > tr > td {
            border: 1px solid #a2a9b1;
            padding: 0.2em 0.4em
        }

        .wikitable > tr > th,.wikitable > * > tr > th {
            background-color: #eaecf0;
            color: #202122;
            text-align: center
        }

        .source {
            font-family: monospace;
            margin-left: 40%;
        }

        .mw-hiero-table {
            border: 0;
            border-spacing: 0;
        }

        table.mw-hiero-table td {
            padding: 0;
            text-align: center;
            vertical-align: middle;
        }

        .mw-hiero-box {
            background: black;
        }

        .mw-mirrored {
            transform: scaleX( -1 );
        }
    </style>
</head>
<body>
    <table class="wikitable">
        <?php
            $indent = str_repeat(' ', 12);

            $headings = array_keys(reset($output));
            $headings = array_map(htmlspecialchars(...), $headings);
            $columns = count($headings);

            echo "$indent<tr>";
            foreach ($headings as $heading) {
                echo "<th>$heading</th>";
            }
            echo "</tr>\n";

            foreach ($output as $text => $renderings) {
                $text = htmlspecialchars($text);
                $text = nl2br($text);
                echo "{$indent}<tr><td class='source' colspan='$columns'>$text</td></tr>\n";

                echo "$indent<tr>";
                foreach ($renderings as $html) {
                    echo "<td>$html</td>";
                }
                echo "</tr>\n";
            }
?>
    </table>
</body>
