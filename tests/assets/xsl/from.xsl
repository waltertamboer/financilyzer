<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fn="http://www.w3.org/2005/xpath-functions">
	<xsl:template match="/financilyzer/transaction"><xsl:value-of select="from" /></xsl:template>
	
	<xsl:template match="/"><html><xsl:apply-templates /></html></xsl:template>
</xsl:stylesheet>