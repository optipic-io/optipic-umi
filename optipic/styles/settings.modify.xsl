<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE xsl:stylesheet SYSTEM "ulang://common">
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:template match="data[@type = 'settings' and @action = 'modify']">
		<xsl:apply-templates select="$errors" />
		<div class="tabs-content module">
			<div class="section selected">
				<div class="location">
					<xsl:call-template name="entities.help.button" />
				</div>

				<div class="layout">
					<div class="column">
						<form method="post" action="do/" enctype="multipart/form-data">
							<xsl:apply-templates select="." mode="settings.modify"/>
							<div class="row">
								<xsl:call-template name="std-form-buttons-settings"/>
							</div>
						</form>
					</div>
					<div class="column">
						<xsl:call-template name="entities.help.content" />
					</div>
				</div>
			</div>
            <script><![CDATA[
                (function() {
                    var optipicCurrentHost = window.location.host;
                    var optipicSid = $("input#site_id").val();
                    var optipicVersion = '1.21.0';
                    if(
                        typeof(optipicCurrentHost)!='undefined'
                        && typeof(optipicSid)!='undefined'
                        && typeof(optipicVersion)!='undefined'
                    ) {
                        var url = 'https://optipic.io/api/cp/stat?domain=' + optipicCurrentHost  + '&sid=' + optipicSid + '&cms=umi&stype=cdn&append_to=.panel-settings&version=' + optipicVersion;

                        var script = document.createElement('script');
                        script.type = 'text/javascript';
                        script.src = url;    

                        document.getElementsByTagName('head')[0].appendChild(script);
                    }
                    
                })();
            ]]></script>
		</div>
        

		<xsl:if test="/result[@method = 'config']">
			<xsl:apply-templates select="/result/@demo" mode="stopdoItInDemo" />
		</xsl:if>
		<xsl:if test="/result[@module = 'content' and @method = 'content_control']">
			<xsl:apply-templates select="/result/@demo" mode="stopdoItInDemo" />
		</xsl:if>
		<xsl:if test="/result[@module = 'emarket' and @method = 'social_networks']">
			<xsl:apply-templates select="/result/@demo" mode="stopdoItInDemo" />
		</xsl:if>
		<xsl:if test="/result[@module = 'search' and @method = 'index_control']">
			<xsl:apply-templates select="/result/@demo" mode="stopdoItInDemo" />
		</xsl:if>
	</xsl:template>

	<xsl:template match="group" mode="settings.modify">
		<xsl:param name="toggle" select="1"></xsl:param>
		<div class="panel-settings">
			<div class="title field-group-toggle">
				<xsl:if test="$toggle = 1 and (count(.) > 1)">
					<div class="round-toggle "></div>
				</xsl:if>

				<h3><xsl:value-of select="@label" /></h3>
			</div>
			<div class="content">
				<xsl:apply-templates select="option" mode="settings.modify" />
			</div>
		</div>
	</xsl:template>

	<xsl:template match="option" mode="settings.modify">
		<div class="row">
			<div class="col-md-4">
				<div class="title-edit">
					<xsl:value-of select="@label" />
				</div>
			</div>
			<div class="col-md-4">
				<xsl:apply-templates select="." mode="settings.modify-option" />
			</div>
		</div>
	</xsl:template>

	<xsl:template match="group" mode="settings.modify.table">
		<div class="panel-settings">
			<div class="title">
				<h3><xsl:value-of select="@label" /></h3>
			</div>
			<div class="content">
				<table class="btable btable-striped middle-align">
					<tbody>
						<xsl:apply-templates select="option" mode="settings.modify.table" />
					</tbody>
				</table>
			</div>
		</div>
	</xsl:template>

	<xsl:template match="option" mode="settings.modify.table">
		<xsl:param name="title_column_width" select="'50%'" />
		<xsl:param name="value_column_width" select="'50%'"/>

		<tr>
			<td width="{$title_column_width}">
				<div class="title-edit">
					<xsl:value-of select="@label" />
				</div>
			</td>

			<td width="{$value_column_width}">
				<xsl:apply-templates select="." mode="settings.modify-option" />
			</td>
		</tr>
	</xsl:template>

	<xsl:template match="option" mode="settings.modify-option">
		<xsl:text>Put here "</xsl:text>
		<xsl:value-of select="@type" />
		<xsl:text>" and code for other options (</xsl:text>
		<a href="/styles/skins/modern/data/settings.modify.xsl">
			<xsl:text>~/styles/skins/modern/data/settings.modify.xsl</xsl:text>
		</a>
		<xsl:text>)</xsl:text>
	</xsl:template>

	<xsl:template match="option[@type = 'string']" mode="settings.modify-option">
		<input type="text" class="default" name="{@name}" value="{value}" id="{@name}" />
	</xsl:template>

	<xsl:template match="option[@type = 'text']" mode="settings.modify-option">
		<textarea rows="3" class="default" name="{@name}" value="{value}" id="{@name}"></textarea>
	</xsl:template>

	<xsl:template match="option[@type = 'bool']" mode="settings.modify-option">
		<input type="hidden" name="{@name}" value="0" />
		<div class="checkbox">
		<input type="checkbox" name="{@name}" value="1" id="{@name}" class="check">
			<xsl:if test="value = '1'">
				<xsl:attribute name="checked">checked</xsl:attribute>
			</xsl:if>
		</input>
		</div>
	</xsl:template>

</xsl:stylesheet>
