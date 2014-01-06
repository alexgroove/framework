<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet 
	version="1.0" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:php="http://php.net/xsl"
	exclude-result-prefixes="php">

<!-- Output settings -->
<xsl:output method="html" indent="no" omit-xml-declaration="yes"/>


<!-- Templates paramters -->
<xsl:param name="HTTP_LOCATION"/>
<xsl:param name="title" select="'MyApp'"/>
<xsl:param name="description" select="'Set a small description of the page'"/>
<xsl:param name="keywords" select="'Some, relevant, keywords'"/>
<xsl:param name="flash" select="''"/>


<!-- Disable default text output for no-matching node -->
<xsl:template match="text()"/>


<!-- MAIN TEMPLATE CONTAINER -->
<xsl:template match="/">

<!-- HTML5 doctype declaration, XSL version -->
<xsl:text disable-output-escaping='yes'>&lt;!DOCTYPE html></xsl:text>
	<html>

		<head>

			<!-- META TAGS -->
	    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>		
			<meta charset="utf-8"/>
			<meta name="description" content="{$description}"/>
			<meta name="keywords" content="{$keywords}"/>

	    <!-- PAGE TITLE -->
			<title><xsl:value-of select="$title"/></title>

			<!-- CSS DEPENDECIES -->
			<link rel="stylesheet" type="text/css" href="{$HTTP_LOCATION}public/css/main.css"/>

		</head>

		<body>

			<!-- MAIN WRAPPER -->
			<div id="wrapper">
				<xsl:apply-templates select="//XML_PARTIAL_CONTAINER"/>
			</div>

			<!-- JAVASCRIPT DEPENDENCIES -->
			<script type="text/javascript" src="{$HTTP_LOCATION}public/js/main.js"/>

		</body>

	</html>

</xsl:template>


</xsl:stylesheet>