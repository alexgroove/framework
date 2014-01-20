<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet 
	version="1.0" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:php="http://php.net/xsl"
	exclude-result-prefixes="php">


<!-- 

Post Link Template
- Use this template to create a link that post a form in the backgroud.
- This is useful because the delete method in a resource controller should be a POST method for security

 -->
<xsl:template name="post_link">
	<xsl:param name="formAction"/>
	<xsl:param name="modelId" select="''"/>
	<xsl:param name="linkText" select="'delete'"/>
	<xsl:param name="warning" select="'yes'"/>
	<xsl:param name="warningMessage" select="'Are you sure you want to delete this item'"/>

	<xsl:variable name="secure_id" select="php:functionString('generate_secure_id')"/>

	<a href="" id="{$secure_id}"><xsl:value-of select="$linkText"/></a>

	<form method="post" action="{$HTTP_LOCATION}{$formAction}" id="{$secure_id}" style="display: none; visibility: hidden;">
		<input type="hidden" name="delete_id" value="{$modelId}"/>
		<input type="hidden" name="secure_key" value="{$SECURE_KEY}"/>
	</form>

	<script type="text/javascript">
		window.addEventListener('load', function () {
			document.getElementById('<xsl:value-of select="$secure_id"/>').addEventListener('click', function (e) {
				e.preventDefault();
				<xsl:choose>
					<xsl:when test="$warning = 'yes'">
					if(window.confirm('<xsl:value-of select="$warningMessage"/>')) {
						document.forms['<xsl:value-of select="$secure_id"/>'].submit();
					}
				</xsl:when>
				<xsl:otherwise>
						document.forms['<xsl:value-of select="$secure_id"/>'].submit();
				</xsl:otherwise>
			</xsl:choose>
			})
		});
	</script>

</xsl:template>

</xsl:stylesheet>