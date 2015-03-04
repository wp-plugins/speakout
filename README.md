SpeakOut! Email Petitions
=======================

A petition plugin for WordPress
___

SpeakOut! Email Petitions allows you to easily create petition forms on your WordPress site.

Compose a petition message and place the form on any page or post using a shortcode or widget. When the petition form is submitted, a copy of your message will be sent to the email address you selected. Included in the email will be the name and contact information provided by the form submitter. After signing the petition, visitors will have the option of sharing your petition page with their followers on Facebook or Twitter.

Signatures are stored in the WordPress database and can be easily exported to CSV format for further analysis. You may set a goal for the number of signatures you hope to collect and then watch as a progress bar tracks your petition's advance toward its goal. Petitions may also be configured to stop accepting new signatures on a specified date.

Stable releases of this plugin can also be found in the [WordPress Plugin Repository] (http://wordpress.org/extend/plugins/speakout-email-petitions/).


Shortcodes
---------------------

The available shortcodes and their available attributes are described below:

### [emailpetition]
Display the petition form.

#### id
The ID number of your petition (required). To display a basic petition, use this format:

```
[emailpetition id="1"]
```

#### width
This sets the width of the wrapper `<div>` that surrounds the petition form. Format as you would a width rule for any standard CSS selector. Values can be denominated in px, pt, em, % etc. The units marker (px, %) must be included.

To set the petition from to display at 100% of it's container, use:

```
[emailpetition id="1" width="100%"]
```

A petition set to display at 500 pixels wide can be achieved using:

```
[emailpetition id="1" width="500px"]
```

#### height
This sets the height of the petition message box (rather than the height of the entire form). Format as you would a height rule for any standard CSS selector. Values can be denominated in px, pt, em, % etc. The units marker (px, %) must be included.

A few notes on using percentages:
Using a % value only works when the "Allow custom messages" feature is turned off—because the petition message will be displayed in a `<div>`. When "Allow custom messages" is turned on, the petition message is displayed in a `<textarea>`, which cannot be styled with % heights. Use px to set the height on petitions that allow message customization.

To set the message box to scale to 100% of the height of the message it contains, use any % value (setting this to 100%, 0%, 200% or any other % value has the same result). Use px if you want the box to scale to a specific height.

```
[emailpetition id="1" height="500px"]
```
```
[emailpetition id="1" height="100%"]
```

#### progresswidth
Sets the width of the outer progress bar. The filled area of the progress bar will automatically scale proportionally with the width of the outer prgress bar. Provide a numeric value in pixels only. Do not include the px unit marker.

To display the progress bar at 300 pixels wide, use:

```
[emailpetition id="1" progresswidth="300"]
```

#### class
Adds an arbitrary class name to the wrapper `<div>` that surrounds the petition form. Typically used to assign the alignright, alignleft or aligncenter classes to the petition in order to float the petition form to one side of its container. To assign multiple classes, separate the class names with spaces.

```
[emailpetition id="1" class="alignright"]
```
```
[emailpetition id="1" class="style1 style2"]
```

### [signaturelist]
Display a table of all signatures collected for a given petition.

#### id
The ID number of your petition (required). To display a basic signature list, use this format:

```
[signaturelist id="1"]
```

#### rows
The number of signature rows to display in the table. This will override the default value provided on the Settings page. To display 10 rows, use:

```
[signaturelist id="1" rows="10"]
```

#### dateformat
Format of values in the date column. Use any of the standard [PHP date formating characters](http://php.net/manual/en/function.date.php). Default is 'M d, Y'. A date such as "Sunday October 14, 2012 @ 9:42 am" can be displayed using:

```
[signaturelist id="1" dateformat="l F d, Y @ g:i a"]
```

#### prevbuttontext
The text that displays in the previous signatures pagination button. Default is &lt;.

#### nextbuttontext
The text that displays in the next signatures pagination button. Default is &gt;.


### [signaturecount]
Display the number (as text) of signatures collected for a given petition:

#### id
The ID number of your petition (required).

```
[signaturecount id="3"]
```