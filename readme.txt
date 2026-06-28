=== KennelFlow Campus Demo ===
Contributors: brelandr
Requires at least: 6.4
Tested up to: 6.8
Requires PHP: 8.0
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Demo WordPress theme for KennelFlow on InstaWP — marketing homepage, owner portal, booking wizards, and WooCommerce styling.

== Description ==

KennelFlow Campus Demo presents a fictional **Harbor Pet Campus** facility with:

* Marketing homepage (boarding, vet, grooming)
* Auto-created pages for KennelFlow shortcodes
* Primary and footer navigation
* Owner portal, booking, and staff calendar page templates
* WooCommerce shop styling
* One-click demo setup under **Appearance → Demo Setup**

Requires KennelFlow Core. Works with KennelFlow Boarding, Vet, Groom, Pro plugins, WooCommerce, and KennelFlow-Data.

== Installation ==

1. Upload the `kennelflow-demo-theme` folder to `wp-content/themes/`
2. Activate **KennelFlow Campus Demo** under Appearance → Themes
3. Go to **Appearance → Demo Setup** and click **Run Demo Setup**
4. Activate KennelFlow plugins (Core first, then spokes, WooCommerce, KennelFlow-Data)
5. Open **KennelFlow → Sample Data** and click **Generate sample data**
6. Visit the site — log in as `demoowner` / `password` for the owner portal

See `instawp-setup.md` for the full InstaWP checklist.

== Demo logins ==

* **Administrator:** admin / password (InstaWP default)
* **Pet owner:** demoowner / password (created by demo setup)

== Shortcode pages ==

| Page | Shortcode |
|------|-----------|
| My Pets | `[ltkf_dashboard]` |
| Book Appointment | `[kennelflow_vet_booking]` (when Vet active) |
| Book Boarding | `[kennelflow_vet_booking]` (Vet active) or `[ltkf_booking]` (Core only) |
| Staff Calendar | `[ltkf_hub_calendar]` |

== Customizer ==

**Appearance → Customize → Harbor Pet Campus** — hero text, contact info, brand colors, hero image.

== Fonts ==

Uses the system font stack by default (no external CDN). Optional: bundle DM Sans woff2 in `assets/fonts/` for custom typography.

== Changelog ==

= 1.0.0 =
* Initial release for InstaWP demos
