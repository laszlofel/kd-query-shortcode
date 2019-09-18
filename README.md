# KD Query Shortcode

The plugin is used to display a list of posts with the shortcode [kd_query_shortcode]. Use the attributes to modify the result. Also the shortcode [kd_query_shortcode_categories] can be used to display post categories.

### List of attributes and defaults

post_type => post,  
offset => 0,  
paging => 1,  
posts => 10,  
cols => 1,  
words => 30,  
read_more => 0,  
category => $_REQUEST['category'] ?: false,  
categories => 0,  
terms => ''  