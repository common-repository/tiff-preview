<?php
/* 
 * Plugin Name: TIFF Preview.
 * Description: When you upload a TIFF attachment, a second jpeg attachment will be created that can be used as the preview of the TIFF. The plugin also makes it so the preview image stands in for the tif image for normal image functions like <em>wp_get_attachment_image()</em> it also sets the preview image as the tif's featured image so calling <em>get_post_thumbnail_id()</em> on the tif ID returns the id for its preview <strong>REQUIRES IMAGICK</strong>
 * Author: Raymond Selzer
 * Author URI: http://www.interslicedesigns.com
 * Plugin Version 1.0
 */

//require dirname(__FILE__) . '/dBug.php';

class TIFFPreview
{
    public function __construct()
    {
        add_action('init',array($this,'init'));
        add_action('add_attachment',array($this,'on_attachment_added'));
        register_activation_hook(__FILE__, array($this,'activate'));
    }
    
    public function activate()
    {
        if(!class_exists('Imagick'))
        {
            die('Tiff Preview uses the PHP extension Image Magick to convert the TIF files to JPG. Please contact your system administrator to enable Image Magick for this site.');
        }
    }
    /**
     *  Does various init things
     */
    public function init()
    {
        
    }
    
    /**
     *  Gets called when an attachment is added, creates the jpeg if the attachment is a tiff
     * @param int $attachment_id
     */
    public function on_attachment_added($attachment_id)
    {
       $attachment = get_attached_file($attachment_id);
       $preview_path = dirname($attachment) . '/test.jpg';
       
       $file_type = wp_check_filetype($attachment);

      if($file_type['type'] == 'image/tiff')
      {
          //new dBug($file_type);
          
            remove_action('add_attachment',array($this,'on_attachment_added'));
          
            //make the jpeg if imagick exists
            //this if statement is really just here because imagick is such a fucking bitch to install I gave up trying to install it on
            //my dev box and just tested the imagick functionality on my ste, and the rest on my dev

            if(class_exists('Imagick'))
            {
                //echo 'imagick exists';
                
                 $attachment_pointer = fopen($attachment, 'r');
                 $preview_path = $attachment . '.jpg';
                 $im = new Imagick();
                 $im->readimage($attachment);
                 $im->setimageformat('jpeg');
                 $im->writeimage($preview_path);
            }
            
            $attachment_post = get_post($attachment_id);
            
            $upload_dir = wp_upload_dir();
            $upload_dir_url = $upload_dir['url'];
            
            //make the new jpeg an actual attachment
            $preview_id = wp_insert_attachment(array(
                'post_title' => 'Preview For ' . basename($attachment),
                'post_status' => 'inherit',
                'guid' => $upload_dir_url . '/' . basename($preview_path),
                'post_content' => 'Source TIF: ' . $upload_dir_url . '/' . basename($attachment),
                'post_mime_type' => $file_type['type']
            ),$preview_path,$attachment_id);
            
            $preview_meta_data = wp_generate_attachment_metadata($preview_id, $preview_path);

            wp_update_attachment_metadata($preview_id, $preview_meta_data);
            
            //set the source tif's extra image sizes by changing the preview's metadata a little to point to the tif as the original, but leave the preview's other sizes
            $attachment_meta_data = $preview_meta_data;
            $attachment_meta_data['file'] = trim($upload_dir['subdir'],'/') . '/' . basename($attachment);
            
            update_post_meta($attachment_id, '_wp_attachment_metadata', $attachment_meta_data);
            
            //also set the preview image as the post thumbnail (featured image) for the tif
            set_post_thumbnail($attachment_id, $preview_id);
      }
    }
}

$TP = new TIFFPreview();