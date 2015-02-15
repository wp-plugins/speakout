=== SpeakOut! Email Petitions ===
Contributors: steved, kreg
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=4PPYZ8K2KLXUJ
Tags: petition, activism, community, email, social media
Requires at least: 4.1
Tested up to: 4.1
Stable tag: 1.0.0

SpeakOut! Email Petitions makes it easy to add petitions to your website and rally your community to support a cause.

== Description ==

SpeakOut! Email Petitions allows you to easily create petition forms on your site.

When visitors to your site submit the petition form, a copy of your message will be sent to the email address you selected. The petition message will be signed with the contact information provided by the form submitter. After signing the petition, visitors will have the option of sharing your petition page with their followers on Facebook or Twitter.

Signatures are stored in the database and can be easily exported to CSV format for further analysis. You may set a goal for the number of signatures you hope to collect and then watch as a progress bar tracks your petition's advance toward it's goal. Petitions may also be configured to stop accepting new signatures on a specified date.

This plugin is a fork of the SpeakOut! plugin by Kreg Wallace that was quite good but needed updates and appears to have been abandoned.

= Localizations =

* Italian **it_IT** ([MacItaly](http://wordpress.org/support/profile/macitaly))
* Slovenian **sl_SI** ([MA-SEO](http://ma-seo.com))
* German **de_DE** (Hannes Heller, Armin Vasilico, Andreas Kumlehn)
* Russian **ru_RU** ([Teplitsa](te-st.ru))
* Dutch **nl_NL** (Kris Zanders)
* Hebrew **he_IL** (Oren L)
* Polish **pl_PL** (Damian Dzieduch)
* Romanian **ro_RO** ([Web Hosting Geeks](http://webhostinggeeks.com))
* French **fr_FR**
* Spanish **es_ES**

The development version of this plugin is now on [GitHub](https://github.com/123host/speakout-email-petitions).

Visit the [SpeakOut! Email Petitions website](http://speakout.123host.com.au/) to learn more.

== Installation ==

Use the automatic installer. Or...

1. Download and unzip the the plugin zip file.
2. Upload the `speakout-email-petitions` folder to your `/wp-content/plugins/` directory
3. Activate SpeakOut! Email Petitions through the "Plugins" menu in the WordPress admin.

== Frequently Asked Questions ==

= How do I create a new petition =
1. Select "Add New" from the "Email Petitions" menu.
2. Complete the "Add New Email Petition" form with the options you desire and save your petition by clicking the "Create Petition" button.
3. Enter the petition's shortcode into any page or post where you want the petition form to appear. Example:
`[emailpetition id="1"]`

= Can I display the petition as a widget? =
Yes. Once you've created a petition, go to the Widgets screen and drag the "SpeakOut! Email Petitions" widget into a sidebar. In the widget's options, enter a Title and a Call to Action and then select the petition you wish to display.

= Why are some people not receiving the confirmation emails? =
Some email services (like AOL, Hotmail, and a few others) do not accept mail sent from the PHP mail() function. So, people who sign your petition with an email address from one of these providers may not be able to receive a confirmation email. To get around this problem, try installing the [WP Mail SMTP plugin](http://wordpress.org/extend/plugins/wp-mail-smtp/) which will redirect calls to the PHP mail() function through your webserver's SMTP configuration.

= How can I create a custom style for the petition form? =
First, select "None" as your theme on the Settings screen. Then add a `petition.css` file to your theme folder. You can use the styles included in the plugin's CSS folder as a starting point for your custom theme — just copy the contents of `theme-standard.css` or `theme-basic.css` into your `petition.css` file and make any modifications you desire.

Custom styles can also be created for the widget and signaturelists by adding petition-widget.css or petition-signaturelist.css to your theme and changing the theme for these items to "None".

= The First Name, Last Name or Email fields in the petition form display the name and email of the site administrator. What's going on? =
These fields are filled automatically for logged-in users. You are seeing the name and email info associated with your user account. Other users will see their own information in these fields. Or, if the user is not logged-in, the fields will be empty.

= Can the petition message be sent to multiple email addresses? =
Yes. In the Target Email field, simply enter a comma-separated list of email addresses.

= Is there a way to confirm a user's email address when they sign a petition? =
Yes. Simply select "Confirm signatures" when creating a petition and a confirmation email will be sent to the address used to sign the petition. By clicking the link in the confirmation email, the signer can confirm their email address. The petition message will not be sent until the signer's email address is confirmed.

= Can I run a petition without having it send email? =
Yes. when you create a new petition, simply select the checkbox labelled "Do not send email (only collect signatures)" at the top of the Petition box and email will not be sent out when the petition is signed.

= Is there a way to publicly display the names of people who have signed my petition? =
Yes, simply place the signaturelist shortcode wherever you want the list to appear in your post (be sure to set the `id` value to match the id number of your petition). Example:
`[signaturelist id="1"]`

= Can I download a list of my petition's signatures? =
Yes. To download the signatures in CSV format, click the "Download as CSV" button at the top of the Signatures screen. If you do not see a "Download as CSV" button on this screen, you will first need to select yuor petition from the drop-down list.

= I downloaded the CSV file, but when I open it in a spreadsheet application, the values aren't in the correct columns. Can I fix this? =
If the CSV file looks scrambled, try changing its filename extension from .csv to .txt and then re-opening it in your spreadsheet app. The columns should be arranged correctly. (If you wish to keep the .csv extension, once you've opened the .txt file, re-save it as a CSV from your spreadsheet app, which will structure the contents of the file in a version of the CSV format that it understands.)

== Screenshots ==

1. Public-facing petition form
2. Form for creating and editing email petitions
3. Table view of existing petitions
4. Table view of collected signatures
5. Plugin settings screen
6. Sidebar widget
7. Pop-up Petition form (widget)
8. Email confirmation screen

== Changelog ==

= 2.4.2 =
* Security update: all users are advised to update

= 2.4.1 =
* Added Return URL option for setting the page that users are redirected to from the email confirmation screen
* Added Russian Localization (thanks to [Teplitsa](te-st.ru))
* Tweaked CSS to improve font rendering on Webkit browsers and correct paragraph margins for users of the Twenty Twelve theme

= 2.4 =
* Reworked the CSS themes (if you're using a custom theme, check to ensure that it still works as expected)
* Added pop-up petition reader to default theme
* Provided LESS sources for editing theme CSS files
* Added AJAX loading animation on form submission
* Moved form labels out of the input boxes
* Added second email field to validate spelling (appears when "Confirm signatures" option is turned on)
* Fixed bug with email confirmations that occurred when Polylang plugin is installed and WPML plugin is not
* Added datalists to provide easier completion of Country and State/Province fields

= 2.3.3 =
* Added [signaturecount] shortcode to display a petition's signature count
* Improved German localization (thanks to Andreas Kumlehn)
* Increased maximum text size allowed in custom fields to 400 characters

= 2.3.2 =
* Fixed conflict with Polylang translations plugin

= 2.3.1 =
* Fixed problem with error messages displaying "Missing argument 2 for wpdb::prepare()" on WordPress 3.5
* Fixed the widget modal popup to work better with Twenty Eleven theme
* Moved screenshots out of plugin folder

= 2.3 =
* Added pagination to signature lists
* Added new attributes to signaturelist shortcode (rows, dateformat, prevbuttontext, nextbuttontext)
* Added option to specify the URL that is submitted by Facebook and Twitter buttons on widgets

[More information](http://speakout.123host.com.au)

= 2.2 =
* Added new styling attributes to the emailpetition shortcode (width, height, progresswidth, class). [More information](http://speakout.123host.com.au/)
* Updated petition theme styles
* Improved reliability of Facebook and Twitter sharing buttons

= 2.1 =
* Added support for [WPML](http://wpml.org/)

= 2.0.5 =
* Fixed problem with default petition theme not being applied on new installs
* Added Polish localization (Thanks to Damian Dzieduch)
* Disabled petition form submit button when clicked to prevent duplicate submissions

= 2.0.4 =
* Fixed problem with spaces not appearing between first and last names on email signatures
* Improved function of Facebook links for widgets on pages that don't include the WP post loop

= 2.0.3 =
* Fixed positioning of widget popup to work better on small screen devices

= 2.0.2 =
* Upadted Add New screen to work with responsive page resizing in WP 3.4
* Compressed images

= 2.0.1 =
* Fixed problem with saving street address field on widget forms
* Fixed bug with expiriration dates not accounting for GMT offset
* Fixed problem with quotation marks not displaying properly in petition message field when using the shortcode

= 2.0 =
* Added option for allowing signatories to customize the petition message
* Added option to only export single or double opt-in signatures to CSV
* CSV files now use petition title and export date in file names. ie: my-petition_2012-03-14.csv
* Settings page is now divided into tabs
* Added support for use of custom widget themes with petition-widget.css
* Added support for use of custom signaturelist themes with petition-signaturelist.css
* Progress bar now displays 4 color states (previously 3)
* Interface improvements
* Lots of code refactoring

= 1.7.4 =
* Fixes problem with "Add New" page not showing on older versions of WordPress
* Fixes problem with saving multiple target email addresses

= 1.7.3 =
* Contextual help tabs will now display when using localizations
* Added Slovenian localization (Thanks to Marko Žagar)
* Updated French localization

= 1.7.2 =
* Fixed bug that caused Twitter messages containing hashtags to fail (introduced in 1.7.1)
* Added Romanian localization (Thanks to [Web Hosting Geeks](http://webhostinggeeks.com))

= 1.7.1 =
* Using petition.css to create a custom style for the petition form now works better with sites running child themes.
* Auto-redirects from the confirmation screen will also now target home_url() rather than site_url().
* Quotation marks can now be used in the Twitter Message box without causing MySQL to freak out.

= 1.7 =
* Fixed bug with custom address fields not being created and displayed properly

= 1.6.2 =
* Fixed 'unserialize() expects parameter 1 to be string' bug when creating and editing new petitions

= 1.6.1 =
* Quick bug fix for 'incorrect data type' error that appeared on existing petitions that do not display the address field 

= 1.6 =
* Added options for collecting granular address data (Street, City, State/Province, Post Code, and Country)
* Added option to customize which columns display in the public signature list.
* Simplified CSS and class names for petition form
* The public signature list header and table will now only display if there are signatures
* Signature counts in the signature list now use commas to separate thousands
* Buttons on admin signature table will now display automatically if you have only one petition
* Added %petition_title% variable to list of available customizations for confirmation email messages
* Confirmation emails can now include quotation marks
* Removed donations link from Settings page

= 1.5.5 =
* Improved performance by caching petition and signature list queries.
* Improved appearance of email confirmation screen
* Added Dutch localization (Thanks to Kris Zanders)
* Signatures table in admin now displays signature number
* Signatures table dates are now localized

= 1.5.4 =
* Fixed a problem with contextual help function throwing an error on older WordPress installs
* Added select box navigation for Signatures admin screen
* Enabled bulk re-sending of confirmation emails to unconfirmed addresses
* Added custom theme support with petition.css.

= 1.5.3 =
* Added contextual help for Add/Edit Petition and Settings screens
* Petition forms now pre-fill first name, last name, and email for logged-in users

= 1.5.2 =
* Fixes problem with vertical centering of widget pop-up form

= 1.5.1 =
* Fixed problem with 'Display Signature Count' not being set by default on new installs
* Fixed positioning problem on widget lightbox pop-up (Thanks to [Leo Gono](http://www.leogono.com/))
* Improved German localization (Thanks to Armin Vasilico)

= 1.5 =
* Added option to include a custom form field
* Petition title is now used as header for petition forms
* Added sharing buttons to widget
* Added option for hiding signature count on petition forms
* Improved German localization (Thanks to Hannes Heller)

= 1.4 =
* Petitions can now be displayed via sidebar widgets
* Signature counts now display on petitions that do not have a goal set
* Improved aesthetics of email confirmation screen
* Added greeting and pseudo signature to message in the petition form
* Petition form message now displays as a div tag, rather than textarea

= 1.3 =
* Added support for RTL languages
* Fixed database fields to support non-Latin characters (UTF-8)
* Added Hebrew localization (Thanks to Oren)
* Fixed signature list display issue that caused IE to crash on lists with more than 999 signatures

= 1.2.2 =
* Added Italian localization (Thanks to MacItaly)
* Updated translation strings
* Changed the way 'Sign Now' button works (Petition reference now stored in name, rather than href attribute).

= 1.2.1 =
* Fixed problem with some new petitions not being saved to the database
* Added French translation
* Changed default confirmation mail subject to "Please confirm your email address". Hat tip to [Alex Pankratov](http://bvckup.tumblr.com/post/9101329123/please-confirm-your-email-address)
* Extended length of target email address field

= 1.2 =
* Added option to include a mailing list opt-in checkbox to petition form

= 1.1.3 =
* Added "Basic" petition theme
* Added Spanish localization

= 1.1.2 =
* Added ability to display signatures list publicly via shortcode
* Fixed problem with Address field not validating as correct XHTML
* Fixed problem with form not submitting on Firefox when "Google Analytics for WordPress" plugin in use
* Added German localization

= 1.1.1 =
* Improved appearance of petition form on mobile devices
* Fixed syntax error when checking if shortcode corresponds to an existing petition
* Labels on public petition forms are now translatable
* Expired petitions now display expiration date, signature count, signature goal and progress bar

= 1.1 =
* Added option for requiring email confirmations
* Fixed Twitter character counter to display correct count on page load when editing petitions
* Removed HTML encoding of quotes on petition message emails
* Added capability for petition emails to be sent to multiple addresses (comma separated)
* Added confirmation box when user attempts to delete a petition
* Signatures progress bar now turns green at 80% complete rather than 100%

= 1.0.1 =
* Fixed SQL error that prevented petition form from displaying for some users
* Removed 'Allow signers to edit message' option from new petition screen
* Compressed images

= 1.0 =
* Initial release

== Upgrade Notice ==

= 2.4.2 =
* Security update: all users are advised to update

[More information](http://speakout.123host.com.au/)

== Emailpetition Shortcode Attributes ==

The following attributes may be applied when using the `[emailpetition]` shortcode

= id =
The ID number of your petition (required). To display a basic petition, use this format:
`[emailpetition id="1"]`

= width =
This sets the width of the wrapper `<div>` that surrounds the petition form. Format as you would a width rule for any standard CSS selector. Values can be denominated in px, pt, em, % etc. The units marker (px, %) must be included.

To set the petition from to display at 100% of it's container, use:
`[emailpetition id="1" width="100%"]`

A petition set to display at 500 pixels wide can be achieved using:
`[emailpetition id="1" width="500px"]`

= height =
This sets the height of the petition message box (rather than the height of the entire form). Format as you would a height rule for any standard CSS selector. Values can be denominated in px, pt, em, % etc. The units marker (px, %) must be included.

A few notes on using percentages:
Using a % value only works when the "Allow custom messages" feature is turned off—because the petition message will be displayed in a `<div>`. When "Allow custom messages" is turned on, the petition message is displayed in a `<textarea>`, which cannot be styled with % heights. Use px to set the height on petitions that allow message customization.

To set the message box to scale to 100% of the height of the message it contains, use any % value (setting this to 100%, 0%, 200% or any other % value has the same result). Use px if you want the box to scale to a specific height.

Examples:
`[emailpetition id="1" height="500px"]`
`[emailpetition id="1" height="100%"]`

= progresswidth =
Sets the width of the outer progress bar. The filled area of the progress bar will automatically scale proportionally with the width of the outer prgress bar. Provide a numeric value in pixels only. Do not include the px unit marker.

To display the progress bar at 300 pixels wide, use:
`[emailpetition id="1" progresswidth="300"]`

= class =
Adds an arbitrary class name to the wrapper `<div>` that surrounds the petition form. Typically used to assign the alignright, alignleft or aligncenter classes to the petition in order to float the petition form to one side of its container. To assign multiple classes, separate the class names with spaces.

Examples:
`[emailpetition id="1" class="alignright"]`
`[emailpetition id="1" class="style1 style2"]`

== Signaturelist Shortcode Attributes ==

= id =
The ID number of your petition (required). To display a basic signature list, use this format:
`[signaturelist id="1"]`

= rows =
The number of signature rows to display in the table. This will override the default value provided on the Settings page. To display 10 rows, use:
`[signaturelist id="1" rows="10"]`

= dateformat =
Format of values in the date column. Use any of the standard [PHP date formating characters](http://php.net/manual/en/function.date.php). Default is 'M d, Y'. A date such as "Sunday October 14, 2012 @ 9:42 am" can be displayed using:
`[signaturelist id="1" dateformat="l F d, Y @ g:i a"]`

= prevbuttontext =
The text that displays in the previous signatures pagination button. Default is &lt;.

= nextbuttontext =
The text that displays in the next signatures pagination button. Default is &gt;.

== Signaturecount Shortcode ==
Display the number (as text) of signatures collected for a given petition:

= id =
The ID number of your petition (required).
`[signaturecount id="3"]`