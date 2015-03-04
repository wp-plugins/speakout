=== SpeakOut! Email Petitions ===
Contributors: 123host, kreg
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=4PPYZ8K2KLXUJ
Tags: petition, activism, community, email, social media
Requires at least: 3.4
Tested up to: 4.1
Stable tag: 1.1.1

SpeakOut! Email Petitions makes it easy to add petitions to your website and rally your community to support a cause by using direct action.

== Description ==

SpeakOut! Email Petitions allows you to easily create petition forms on your site.

When visitors to your site submit the petition form, a copy of your message will be sent to the email address you specified e.g. your mayor. The petition message will be signed with the contact information provided by the form submitter. After signing the petition, visitors will have the option of sharing your petition page with their followers on Facebook or Twitter.

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
= 1.1.1 =

Getting dashboard icons right

= 1.1.0 =

Fix broken directory references missed as part of fork.

= 1.0.0 =

Initial fork of SpeakUp! with additional privacy option in setting so only display first letter of surname

== Upgrade Notice ==
= 1.1.0 =

Upgrade required

= 1.0.0 =
* No upgrade at this time

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