<?php
if (extension_loaded("mongodb")) {
    echo "L'extension mongodb est chargée !";
} else {
    echo "❌ Extension mongodb non chargée !";
}
