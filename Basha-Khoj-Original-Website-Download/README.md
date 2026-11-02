# Basha Khoj — Hostinger-ready website

## What is included
- Vanilla HTML5, CSS3 and ES6 JavaScript
- Responsive premium marketplace design
- Homepage, rentals/search, property detail, locations, property types, lifestyle pages, about, how it works, trust, FAQ, contact, account and legal pages
- Centralized `js/properties.js` property data
- Centralized `js/blogData.js` blog data
- Centralized `js/portfolioData.js` portfolio data
- PHP contact endpoint prepared for Hostinger
- Accessibility basics: skip link, semantic sections, labels, focus states, reduced motion
- SEO metadata and WebSite structured data on the homepage

## Publishing
1. Upload the contents of this folder to your Hostinger `public_html` directory.
2. Keep the folder structure unchanged.
3. Replace the sample Unsplash image URLs with optimized local WebP/AVIF images before launch.
4. Configure the contact endpoint in `api/contact.php`.
5. For SMTP, use a server-side mailer such as PHPMailer and keep credentials outside the public web root. Do not commit SMTP passwords to JavaScript or public files.
6. Replace placeholder privacy/terms/cookie copy with final legal documents.
7. Connect your real authentication, booking, map and database/API backend.

## Contact form / SMTP
Recommended private server configuration:
- SMTP host: Hostinger SMTP host for your mailbox
- SMTP port: the port provided in Hostinger Email settings
- SMTP username: your Basha Khoj mailbox
- SMTP password: your mailbox/app password
- From address: your Basha Khoj mailbox
- To address: your support mailbox

Never expose SMTP credentials in frontend JavaScript.

## Updating properties
Edit only `js/properties.js`. The homepage, rentals and property detail rendering consume this dataset.

## Updating blog posts
Edit only `js/blogData.js`. The blog overview and article renderer consume this dataset.

## Updating portfolio
Edit only `js/portfolioData.js`. Add projects using the same object shape. The architecture is intentionally data-driven so styling/layout remains independent of content.

## Production note
The frontend is production-oriented, but a real marketplace still needs backend services for authentication, database inventory, live availability, bookings, messaging, maps, verification workflows and payment processing.

## Property photo uploads
The `list-property.html` form now supports multiple owner-uploaded property photos with drag/drop, previews, removal, cover-photo selection and client-side validation. It submits `multipart/form-data` to `api/list-property.php`.

### Backend-ready upload flow
- Photos: JPG, PNG or WebP; max 20 images; max 10 MB each.
- Server validates MIME type and size using PHP `finfo`, generates random filenames, and stores files under `uploads/properties/`.
- Listing metadata is saved as a pending JSON record under `storage/pending-listings/` as a simple Hostinger-compatible staging layer.
- Replace that staging write with PDO/MySQL or your production API and add SMTP notification after persistence.
- Keep `uploads/` and `storage/` writable by the PHP process. In production, consider storing images outside the public web root or using object storage/CDN.
- Do not put SMTP/database credentials in JavaScript; use Hostinger environment/configuration on the server.


## Feedback update — September 2026
- Added rotating homepage property imagery with a 5-second right-to-left slide transition and changing slogans.
- Added a persistent header Search control and mobile navigation containing Find a Place, Explore, Guides, About, List Your Property, Search and Sign in.
- Added hierarchical Bangladesh search: division → district → upazila, plus a ৳0–৳5 crore price range and property-type filters.
- Added property short-description, utility/security detail chips, question and review panels with two-item previews and expandable full lists.
- Added search-context-aware property suggestions so location, budget and type filters carry from results into the detail page and recommendations.
- Added sample structured property fields for gas, electricity backup, parking and security.
- Added `js/bangladeshGeo.js`; the division/district layer follows the Bangladesh National Portal's 8-division/64-district structure. Upazila options use a bilingual structured dataset endpoint and should be copied locally for a fully self-contained production deployment.
- The uploaded feedback also requested fixing an error shown in the reference; the current build removes fragile navigation/initialization behavior and guards dynamic sections so pages without a matching data block do not fail.
