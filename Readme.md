# CakePHP Bootstrap Dialog

## Overview

This plugin allows you to create dialog pop-up windows in your controllers and display them in the views. This way you can keep the logic for showing a dialog in the controller and the html content for the dialog in a separate file - completely decoupled from the view you wnat to show it in.

## Setup
First, get the plugin code in *app/Plugin/BootstrapDialog* folder.

Second. load the plugin in your bootstrap.php file 

	CakePlugin::load('BootstrapDialog')

Third, add it to the controller in which you would like to use the component

	public $components = array(
		'Dialog' => array(
			'className' => 'BootstrapDialog.Dialog')
		)
	)
Finally, echo the dialog content in your default layout just under the body tag.

	<html>
	...
	<body>
		<?php echo $dialog; ?>
		...

In addition, you will have to include twitter bootstrap front-end libraries (if you haven't done that already). You can use the [Bootstrap CDN](http://www.bootstrapcdn.com/). 

	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css">
	<script type="text/javascript" src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
	
The current version was built for Twitter Bootstrap 2.3.2 but it will probably work with 3.x, too.

## Usage
Dialogs can be added to the current request or the next page load.

#### Current request a dialogs
You can set a dialog for the current page load. To choose what the content of the dialog should be you will have to set one of *template*, *templateUrl*, or *content*. 

* **template**: a view within View/Dialogs/ directory. You can pass parameters to it via the *params* property.
* **tempalteUrl**: url to be loaded via ajax call. You can pass post parameters via the *params* property.
* **content**: static text

Here is the full list of parameters you can pass to the dialog:

	$this->Dialog->setDialogForCurrnetPage(array(
		'template'		=> false,
		'templateUrl'   => false,
		'content'		=> false,
		'title'			=> '', // the title of the dialog
		'params'		=> array(), // params to pass to template or templateUrl
				
		'width'			=> 400,			// optional, default: 400
		'height'		=> 200,			// optional, default: 200
		'autoOpen'		=> true,		// optional, default true
		'dialogId'		=> 'dialog',	// optional, default: random, id attribute of the dialog root html element
		'hideFooter'	=> false,		// optional, default false, whether to show the buttons in the footer or no
		'hideXButton' => false,			// optional, default false, whether to hide the X (close) button of the modal
	))

#### Next page load dialogs
Dialogs can also be queued for the next page load which is useful if you are going to redirect. Use this command in that case:

	$this->Dialog->setDialogForNextReload(…);
	
Queued dialogs can be postponed for the next page load with *$this->Dialog->supressDialog()*. This is useful if you have implemented a wizzerd register flow and you need to show a dialog after a the last step. Thus, you will *supress* the dialog during the registration steps and show it only after the user is fully registered.

	$this->Dialog->suppressDialog();