<?php
/*
Plugin Name: Wiki Links 0.2
Plugin URI: http://liquidstudios.ro/experimente/proiecte/plugin-wordpress-wiki-links
Description: Create links out of words that match post titles to generate quick cross-links.
Version: 0.2
Author: Vlad Babii
Author URI: http://liquidstudios.ro/
*/

class wiki_links {
  static $post_name_list=array();
	static $post_name_done=false;
	
  function work($content) {
	  $this->get_postnames();
		foreach($this->post_name_list as $article_name => $article_link)
		{
		  if(
			    isset($content) &&  strlen($content)>0 
					&& 
				  isset($article_name) && strlen($article_name)>0 
					&& 
					strpos($content,$article_name)) 
			{
			  $content=str_replace($article_name,'<a href="'.$article_link.'">'.$article_name.'</a>',$content);
			}
		}
	  return $content;
  }
	
	function get_postnames() {
	  if($this->post_name_done == false)
		{
		  $this->post_name_list=array();
 			$myposts = get_posts('order=ASC');
 			foreach($myposts as $post)
			{
  			$this->post_name_list[ $post->post_title ] = get_permalink($post->ID);
      }
			$this->post_name_done=true;
		}
	}
}

if(!isset($wikiTransformer))
{
  $wikiTransformer=new wiki_links;
}
add_filter('the_content' ,array( &$wikiTransformer ,'work'));
?>