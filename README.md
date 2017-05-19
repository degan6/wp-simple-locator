# Tech2u Locations Plugin


## Overview

This plugin is designed to create locations within wordpress using a custom post type and create pages that use 
shortcodes to locize contact information

This plugin was created from  [locatewp.com](http://locatewp.com).

#### Page and Location inheritance

This plugin is designed to be used with a site that pages and subpages for each location. 

Pages are assigned a location and when short codes like ````[wp_simple_locator_phone]```` is placed on the page it will 
display the assigned location's phone number. 

Subpages take the location of the top parent, if no location is assigned in chain the root location is used.

If a page has a location with  missing information (such as the phone number) the phone number from the root location 
is used.

###Testimonials

This plugin links to the testimonials plugin installed on the Tech2u Site. When creating a testimonials you must select 
a location to associate the testimonial with.

Associated testimonials for the location will display in location editor.

###Json-LD
This plugin implements schema.org json-ld data in the header on all front end pages bases on the pages parent or location 
set on the page.

#### Requirements

Simple Locator requires WordPress version 3.8+ and PHP version 5.4+. Simple Locator version 1.1.5 (no longer maintained) is compatible with PHP version 5.3.2+.


#### Usage
To display the locator, include the shortcode ```[wp_simple_locator]```. See available options and customization on the [plugin website](http://locatewp.com)

###Tech2u Shortcodes

#####Phone Numbers
```[wp_simple_locator_phone_number]```
#####Website
```[wp_simple_locator_website]```
#####Payments Accepted
```[wp_simple_locator_payments_accepted]```
#####Logo
```[wp_simple_locator_logo]```
#####SameAs
```[wp_simple_locator_same_as]```
#####Price Range
```[wp_simple_locator_price_range]```
#####Email
```[wp_simple_locator_email]```
#####Areas Served
```[wp_simple_locator_areas_served]```
#####Address
```[wp_simple_locator_address]```
#####Hours
```[wp_simple_locator_hours]```

#### Filters
Full form output and query customization is available through the plugin filters. See the [plugin website](http://locatewp.com) for full examples and documentation. By using the various filters, it is possible to add a fully-customized search form, using any number of custom criteria.


```simple_locator_form_filter($output, $distances, $taxonomies, $widget)```  
Customize the form HTML output. Custom fields may be added to the form, and accessed via the post field filter and query filters.


```simple_locator_result($output, $result, $count)```  
Customize the HTML output of each result in the list view.


```simple_locator_infowindow($infowindow, $result)```  
Customize the HTML output for the Google Maps Info Window for each result.


```simple_locator_post_fields()```  
Include custom fields in the form POST data, for use in custom query filters. Fields should be passed as an array of field names that correspond to the custom input names added in the ```simple_locator_form_filter``` filter.


```simple_locator_sql_select($sql)```  
Customize the SELECT statement in the search query.


```simple_locator_sql_join($sql)```  
Customize JOINS in the search query.

```simple_locator_sql_where($sql)```  
Customize the WHERE clauses in the search query.


###Todo

- [] Hours shortcode
- [] Address shortcode
- [] Test shortcodes in vc
 