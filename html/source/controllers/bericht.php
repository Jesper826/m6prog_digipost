<?php
echo "Bericht controller.";

if ($_GET['action'] == 'view') {
    echo " Viewing bericht.";
} elseif ($_GET['action'] == 'create') {
    echo " Creating bericht.";
} else {
    echo " Unknown action.";
}