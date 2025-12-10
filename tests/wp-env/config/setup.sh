#!/bin/bash
set -eox pipefail

echo "=== SETUP.SH DEBUG ==="
echo "Current working directory:"
pwd
echo ""

echo "WordPress themes directory contents:"
ls -la /var/www/html/wp-content/themes/ || echo "Could not list themes directory"
echo ""

echo "Checking for hello-elementor theme specifically:"
if [ -d "/var/www/html/wp-content/themes/hello-elementor" ]; then
    echo "✅ hello-elementor directory found"
    echo "Contents:"
    ls -la /var/www/html/wp-content/themes/hello-elementor/
    echo ""
    
    echo "Checking for style.css:"
    if [ -f "/var/www/html/wp-content/themes/hello-elementor/style.css" ]; then
        echo "✅ style.css found"
        echo "Theme header:"
        head -10 /var/www/html/wp-content/themes/hello-elementor/style.css || true
    else
        echo "❌ style.css missing"
    fi
else
    echo "❌ hello-elementor directory not found"
    echo "Available theme directories:"
    ls -la /var/www/html/wp-content/themes/
fi
echo ""

wp plugin activate elementor
echo "Available themes (via WP-CLI):"
wp theme list
echo ""

echo "Attempting to activate hello-theme theme..."
wp theme activate hello-theme || {
    echo "❌ Failed to activate hello-theme, trying hello-elementor..."
    wp theme activate hello-elementor || {
        echo "❌ Both activation attempts failed. Final theme list:"
        wp theme list
        echo "❌ Available theme directories in WordPress:"
        ls -la /var/www/html/wp-content/themes/
        echo "❌ Theme activation completely failed"
        exit 1
    }
}

WP_CLI_CONFIG_PATH=hello-elementor-config/wp-cli.yml wp rewrite structure '/%postname%/' --hard

# Remove the Guttenberg welcome guide popup
wp user meta add admin wp_persisted_preferences 'a:2:{s:14:\"core/edit-post\";a:2:{b:1;s:12:\"welcomeGuide\";b:0;}}'

# Reset editor counter to avoid auto trigger of the checklist popup when entering the editor for the 2nd time
wp option update e_editor_counter 10
wp option update elementor_checklist '{"last_opened_timestamp":null,"first_closed_checklist_in_editor":true,"is_popup_minimized":false,"steps":[],"should_open_in_editor":false,"editor_visit_count":10}'

wp option set elementor_onboarded true

# Add user meta so the announcement popup will not be displayed - ED-9723
for id in $(wp user list --field=ID)
	do wp user meta add "$id" "announcements_user_counter" 999
	wp user meta add "$id" "elementor_onboarded" "a:1:{s:27:\"ai-get-started-announcement\";b:1;}"
done

wp cache flush
wp rewrite flush --hard
wp elementor flush-css
