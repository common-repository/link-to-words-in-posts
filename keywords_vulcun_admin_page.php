<style>
input{margin-left:50px;}
select{margin-left:50px;}
td{font-size:14px; color:#666666; font-family:Arial, Helvetica, sans-serif;}
</style>
<div class="wrap">
<?php 
if($_POST['vulcun_hidden']=='Y'&&$_POST['vulcun_keyword']!=''&&$_POST['vulcun_link']!='')
{
	
	$vulcun_post=$_POST['vulcun_post'];
					global $wpdb;
                    $query = "SELECT * FROM $wpdb->posts WHERE post_type='post' and post_status='publish' and post_title='".$vulcun_post."'";
    			         $posts = $wpdb->get_results($query); 
      			                    foreach( $posts as $post ) :
                                 		 $post_title=$post->post_title; 
										 $post_id=$post->ID;  
										 $post_content=$post->post_content; 
                                   	endforeach;  
                                     
						 
								     
	 $vulcun_keyword=$_POST['vulcun_keyword'];
	 $vulcun_link=$_POST['vulcun_link'];
	 $vulcun_relative=$_POST['vulcun_relative'];
	 $vulcun_title=$_POST['vulcun_title'];
	 $vulcun_target=$_POST['vulcun_target'];
	 if($vulcun_target=='new_window')
	 {
		 $other_attribute='target="_blank"';
	 }
 	 $message=	add_vulcun_link($post_id,$post_content,$vulcun_keyword,$vulcun_link,$vulcun_relative,$vulcun_title,$other_attribute);	
	
}


function add_vulcun_link($post_id,$content,$keyword,$link,$relative,$linktitle,$other_attribute)
{
	$post_content=$content;
	$text = explode(" ",$post_content);
					$no_of_links_applied=0; 
					for($i = 0; $i < count($text); $i++)
					{
						 
						if ($text[$i]==$keyword)
							{    
								 $no_of_links_applied++;
								 $words[] = $text[$i]; 
							} 
					}
 
				if($words!='')
				{
					
							foreach($words as $newword)
							{
									if (strpos($newword,'/\b(http?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i'))
									{
									  $condition="haslink";
									}
						 			else
									{ 
									 
									 $condition="true";
									}	
					
							}
							
				}
				else 
				{
					$message="Keyword Does not exists or already have a link";
				}
				
				if($condition=="true")
						{
							$new_linked_keyword = '<a href="'.$link.'" title="'.$linktitle.'"  '.$other_attribute.' rel="'.$relative.'" ">'.$keyword.'</a>';
								
									/* Applying links to Keywords*/
						//	$string = preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $string);
									 
									 
							$new_content = str_replace($keyword, $new_linked_keyword, $post_content);
								
									/*Return Content*/
									global $wpdb;
					 				$update_query = "update $wpdb->posts set post_content='".$new_content."' WHERE ID='".$post_id."'";
									$wpdb->query($update_query);
								//	$plugin_table="kewords_links";
								 
								//	$insert_query="insert into ".$plugin_table." set post_id='".$post_id."',keyword='".$keyword."',no_of_links='".$no_of_links_applied."', url='".$link."'";
								//	$wpdb->query($insert_query);
									$message="Link Successfully Added to the Post </br>";
									$message.="No of Links Added: ";
									$message.=$no_of_links_applied;
									 
						}
						if($condition=="haslink")
						{
						$message="Keyword Cant be linked, becuase its already have a linked";
						}			
			return $message;
}
?>


			
			<?php    echo "<h2>" . __( 'Adding Links to Keywords', 'add_links' ) . "</h2>"; ?>
            	<hr />
            <h2><?php echo $message;?></h2>
			<form name="vulcun_linking_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
				<input type="hidden" name="vulcun_hidden" value="Y">
				
	           	<table>
                <tr>
                <td>
                Select Post:</td>
                <td><select name="vulcun_post">
                    <?php
                    global $wpdb;
                    $query = "SELECT * FROM $wpdb->posts WHERE post_type='post' and post_status='publish'";
    
                        $posts = $wpdb->get_results($query); 
    
                                /*	Sending posts one by one to API url*/
    
                                    foreach( $posts as $post ) :
                                    ?><option><?php	echo  $post_title=$post->post_title;   ?></option>
                                    <?php	endforeach; ?>
                    </select></td>
				</tr>
                <tr>
                <td>
				Keyword here:</td><td><input type="text" name="vulcun_keyword"  size="20">
				</td>
                </tr>
                <tr>
                <td>Link to be add:</td>
                <td><input type="text" name="vulcun_link"  size="20">
				</td>
                </tr>
                <tr>
                <td>Title of Link: </td>
                <td><input type="text" name="vulcun_title"  size="20">
				</td>
                </tr>
                <tr>
                <td>Relative:</td>
                <td>
                <select name="vulcun_relative">
                	<option value="follow">
                    Follow
                    </option>
                    <option value="nofollow">
                    No-Follow
                    </option>
                </select>
				</td>
                </tr>
                
                
                <tr>
                <td>Target:</td>
                <td>
                <select name="vulcun_target">
                	<option value="same_window">
                    Open in Same Window
                    </option>
                    <option value="new_window">
                    Opne in New Window
                    </option>
                </select>
				</td>
                </tr>
            <table>
            	<hr />
				<p class="submit">
				<input type="submit" name="Submit" style="margin-left:10px;" value="<?php _e('Add Link', 'add_links' ) ?>" />
				</p>
			</form>

</div>
	