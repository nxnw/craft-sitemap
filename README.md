Craft Sitemap Plugin
=====================

### I could still use help testing and bug fixing. If you find any issues put them in the Github issues. Thanks

This is a plugin for the Craft CMS to add sitemap generation functionality. Based on the options you select for your Sections, it generates a sitemap.xml file for all the entries of the sections you want included.  Entries must be live to be included in sitemap.xml file.

###Installation

1. Clone this project into `your_craft_dir/craft/plugins/sitemap`
2. Install the plugin through the Craft admin panel

###Usage

1. Click Sitemap on Control Panel Navigation
2. Select the checkbox of Sections you would like included in your sitemap.xml file
3. Select the frequency in which you believe changes will be made to the Entries in each Section.
4. Select the priority of included files. 1.0 is the highest priority and 0.0 is the lowest.
5. Either click
    - 'Save' to just save your configurations and generate the sitemap
    - 'Save & Ping' to save configurations, generate the sitemap, AND ping search engines to let them know to crawl your site