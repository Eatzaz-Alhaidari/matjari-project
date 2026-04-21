<?php
exec('git remote -v', $output);
echo implode("\n", $output);
