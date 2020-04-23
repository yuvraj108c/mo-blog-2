<?xml version="1.0" encoding="UTF-8" ?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/">
        <html>
            <!-- Link to Semantic UI CDN-->
            <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.css" />
            <link rel="stylesheet" type="text/css" href="./assets/css/dashboard.css" />
            <body>
                <div class="ui divided items">
                    <!-- Loop through xml nodes to display posts-->
                    <xsl:for-each select="posts/post">
                        <xsl:sort select="id" data-type="number" order="descending" />
                        <div class="item">
                            <div class="ui small image">
                                <img src="{imageUrl}" />
                            </div>
                            <div class="content">
                                <div class="header">
                                    <a href="details.php?id={id}">
                                        <xsl:value-of select="title" />
                                    </a>
                                </div>
                                <div class="meta">
                                    <span class="cinema">
                                        By
                                        <xsl:value-of select="author" />
                                    </span>
                                </div>
                                <div class="description">
                                    <p>
                                        <xsl:value-of select="description" />
                                    </p>
                                </div>
                                <div class="extra">
                                    <span class="date">
                                        <i class="left calendar icon"></i>
                                        <xsl:value-of select="createdOn" />
                                    </span>
                                    <span class="ui label">
                                        <xsl:value-of select="category" />
                                    </span>
                                    <a class="ui right floated red small button" href="includes/handlers/delete-handler.php?id={id}">
                                        Delete
                                    </a>
                                    <a class="ui right floated teal small button" href="edit.php?id={id}">
                                Edit
                            </a>
                                </div>
                            </div>
                        </div>
                    </xsl:for-each>
                </div>
                <!-- End of Loop-->
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>