# KennelFlow Demo — InstaWP Setup

Use this checklist when creating an InstaWP template for the full KennelFlow stack.

## 1. Plugins (activate in order)

1. **KennelFlow Core** (required)
2. **KennelFlow Boarding**
3. **KennelFlow Vet**
4. **KennelFlow Groom**
5. **KennelFlow Boarding Pro** (optional — WooCommerce)
6. **KennelFlow Vet Pro** (optional)
7. **KennelFlow Groom Pro** (optional)
8. **WooCommerce** (for Pro payment demos)
9. **KennelFlow-Data** (internal — sample data seeder)

## 2. Theme

1. Upload `kennelflow-demo-theme` to `wp-content/themes/`
2. Activate **KennelFlow Campus Demo**
3. **Appearance → Demo Setup → Run Demo Setup**
4. **Settings → Permalinks → Save** (required for `/kennelflow-mobile/` PWA URL)

## 3. Sample data

1. **KennelFlow → Sample Data**
2. Click **Generate sample data**
3. Confirm coverage matrix shows green for active modules

This populates locations, pets, bookings (80 calendar slots), EMR records, commissions, and WooCommerce orders.

## 4. Verify frontend

| URL | Expected |
|-----|----------|
| `/` | Marketing homepage |
| `/my-pets/` | Owner portal (login required) |
| `/book-appointment/` | Vet booking wizard |
| `/staff-calendar/` | Hub calendar (staff login) |
| `/shop/` | WooCommerce (if active) |

## 5. Demo roles (sandbox switcher)

After **Generate sample data**, a **KennelFlow sandbox** bar appears at the top of every page. Click a role to switch instantly — no new InstaWP instance required. The WordPress admin bar also includes **Demo as…** when logged in.

| Role | Username | Password |
|------|----------|----------|
| Pet owner | demoowner | password |
| Veterinarian | kfdemo_vet | password |
| Groomer | kfdemo_groomer | password |
| Boarding desk | kfdemo_desk | password |
| Site admin | admin | password |

**Landing pages after switch:** Pet owner → My Pets · Veterinarian / Groomer → Staff Calendar · **Boarding desk → KennelPress admin** · Site admin → WP Admin.

## 5b. Boarding / kennel demo walkthrough

Use this script when the sandbox should highlight **KennelFlow Boarding** (with or without Vet/Groom):

| Step | Switch to | Then open |
|------|-----------|-----------|
| 1 — Customer books a stay | **Pet owner** | `/book-boarding/` (or **My Pets** → portal) |
| 2 — Desk checks kennels | **Boarding desk** | **KennelPress** menu → Kennel calendar / Kennel bookings |
| 3 — Hub calendar (all services) | **Boarding desk** or **Site admin** | `/staff-calendar/` (frontend hub calendar) |
| 4 — Kennels, locations, facility rules | **Site admin** | **KennelFlow → Locations**, **KennelPress → Facility settings** |
| 5 — Mobile report card (Pro) | **Site admin** or desk staff | `/kennelflow-mobile/` (footer link) |

Sample data seeds **hub locations** (campuses), **kennel runs** per location, and **boarding bookings** on the calendar. Hub location names are resort-style; each campus also has kennel inventory for occupancy demos.

**Boarding-only InstaWP template:** activate **Core + Boarding + KennelFlow-Data** (Vet/Groom optional). The switcher still includes **Pet owner**, **Boarding desk**, and **Site admin**.

Additional seeded staff users (random logins) remain for volume testing; use the switcher for guided demos.

## 6. Staff admin shortcuts

* **Pets → Calendar** — Omni-Booking hub calendar
* **KennelPress** menu — Boarding calendar, mobile report card
* **GroomPress** menu — Grooming schedule
* **KennelFlow Vet Clinical** — EMR and vet bookings

## 7. Save InstaWP snapshot

Once verified, save the InstaWP site as a template so new demos start with theme, pages, menus, and sample data pre-loaded.

## Customizer branding

**Appearance → Customize → Harbor Pet Campus** — rename the facility, update hero copy, phone, address, and colors without editing code.
