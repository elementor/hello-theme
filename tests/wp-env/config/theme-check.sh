#!/bin/bash
set -euo pipefail

wp plugin install theme-check --activate --force
wp theme install /var/www/html/hello-elementor-config/hello-elementor-dist.zip --force --activate
wp theme-check run hello-elementor --format=table
